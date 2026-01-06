<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Question::with('options');
        
        if ($search) {
            $query->where('question_text', 'like', "%{$search}%");
        }
        
        $questions = $query->latest()->paginate(10);
        $questions->appends(['search' => $search]);
        
        return view('admin.questions.index', compact('questions', 'search'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        return view('admin.questions.create');
    }

    /**
     * Store a newly created question and its options.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'is_correct' => 'required|integer|min:0',
        ]);

        $question = Question::create([
            'question_text' => $validated['question_text'],
        ]);

        foreach ($validated['options'] as $index => $optionText) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'is_correct' => $index == $validated['is_correct'],
            ]);
        }

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        $question->load('options');
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $question->load('options');
        return view('admin.questions.edit', compact('question'));
    }

    /**
     * Update the specified question and its options.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'is_correct' => 'required|integer|min:0',
            'option_ids' => 'array',
            'option_ids.*' => 'integer',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
        ]);

        // Delete old options
        $question->options()->delete();

        // Create new options
        foreach ($validated['options'] as $index => $optionText) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'is_correct' => $index == $validated['is_correct'],
            ]);
        }

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified question.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question deleted successfully.');
    }
}
