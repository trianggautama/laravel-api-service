<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizResult;
use App\Models\Question;
use App\Models\QuestionOption;

class QuizController extends Controller
{
    public function quizSubmitHandle(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer|exists:questions,id',
            'answers.*.answer' => 'required|string',
        ]);

        // Get authenticated user from middleware
        $user = $request->input('authenticated_user');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $answers = $validated['answers'];
        $totalQuestions = count($answers);
        $correctAnswers = 0;
        $results = [];

        // Process each answer
        foreach ($answers as $answer) {
            $questionId = $answer['question_id'];
            $userAnswer = $answer['answer'];

            // Get the question with its options
            $question = Question::with('options')->find($questionId);

            if (!$question) {
                $results[] = [
                    'question_id' => $questionId,
                    'user_answer' => $userAnswer,
                    'is_correct' => false,
                    'correct_answer' => 'Question not found',
                ];
                continue;
            }

            // Find the correct answer from options
            $correctOption = $question->options->where('is_correct', true)->first();
            $correctAnswerText = $correctOption ? $correctOption->option_text : '';

            // Check if user's answer matches the correct answer (case-insensitive comparison)
            $isCorrect = false;
            if ($correctOption) {
                // Compare answers - you might need to adjust the comparison logic
                // based on how answers are stored and compared
                $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($correctAnswerText));
            }

            if ($isCorrect) {
                $correctAnswers++;
            }

            $results[] = [
                'question_id' => $questionId,
                'question_text' => $question->question_text,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'correct_answer' => $correctAnswerText,
            ];
        }

        // Calculate score as percentage
        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        // Save quiz result to database
        $quizResult = QuizResult::create([
            'user_id' => $user->id,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'score' => round($score),
            'answers' => $results,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz submitted successfully',
            'data' => [
                'quiz_result_id' => $quizResult->id,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'score' => round($score),
                'results' => $results,
            ]
        ], 200);
    }
}
