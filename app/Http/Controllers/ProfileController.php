<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends \App\Http\Controllers\Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Generate a new API key for user.
     */
    public function regenerateApiKey(Request $request)
    {
        $user = Auth::user();
        $newApiKey = $user->generateApiKey();
        
        return back()->with('success', 'New API key generated successfully!');
    }

    /**
     * Show user's quiz results.
     */
    public function quizResults()
    {
        $user = Auth::user();
        $quizResults = QuizResult::where('user_id', $user->id)->latest()->paginate(10);
        
        return view('user.quiz-results', compact('quizResults'));
    }

    /**
     * Display detailed quiz result for the current user.
     */
    public function quizResultDetail($id)
    {
        $user = Auth::user();
        $quizResult = QuizResult::where('user_id', $user->id)->where('id', $id)->first();

        if (!$quizResult) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz result not found'
            ], 404);
        }

        return response()->json([
            'id' => $quizResult->id,
            'total_questions' => $quizResult->total_questions,
            'correct_answers' => $quizResult->correct_answers,
            'score' => $quizResult->score,
            'answers' => $quizResult->answers,
        ]);
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'npm' => 'nullable|string|max:50',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:male,female,other',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
                Storage::delete('public/photos/' . $user->photo);
            }

            $photoPath = $request->file('photo')->store('public/photos');
            $user->photo = basename($photoPath);
        }

        $user->name = $request->name;
        $user->npm = $request->npm;
        $user->birth_place = $request->birth_place;
        $user->birth_date = $request->birth_date;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
