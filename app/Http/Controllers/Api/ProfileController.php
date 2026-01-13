<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QuizResult;

class ProfileController extends Controller
{
    /**
     * Get user profile with quiz statistics
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        // Get authenticated user from middleware
        $user = $request->input('authenticated_user');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Get quiz statistics
        $quizResults = QuizResult::where('user_id', $user->id)->get();
        $totalSubmissions = $quizResults->count();
        
        $averageScore = 0;
        if ($totalSubmissions > 0) {
            $averageScore = $quizResults->avg('score');
        }

        // Format birth date if exists
        $birthDate = null;
        if ($user->birth_date) {
            $birthDate = $user->birth_date->format('Y-m-d');
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'npm' => $user->npm,
                    'birth_place' => $user->birth_place,
                    'birth_date' => $birthDate,
                    'address' => $user->address,
                    'gender' => $user->gender,
                    'photo' => $user->photo ? asset('storage/photos/' . $user->photo) : null,
                    'member_since' => $user->created_at->format('F j, Y'),
                ],
                'quiz_statistics' => [
                    'total_submissions' => $totalSubmissions,
                    'average_score' => round($averageScore, 2),
                ]
            ]
        ], 200);
    }
}
