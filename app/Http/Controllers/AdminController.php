<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $recentPosts = Post::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalPosts', 'recentPosts', 'recentUsers'));
    }

    /**
     * Display all users.
     */
    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Display all posts.
     */
    public function posts()
    {
        $posts = Post::with('user')->paginate(10);
        return view('admin.posts', compact('posts'));
    }

    /**
     * Display all quiz results.
     */
    public function quizResults()
    {
        $quizResults = QuizResult::with('user')->latest()->paginate(10);
        return view('admin.quiz-results', compact('quizResults'));
    }

    /**
     * Display detailed quiz result.
     */
    public function quizResultDetail($id)
    {
        $quizResult = QuizResult::with('user')->find($id);

        if (!$quizResult) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz result not found'
            ], 404);
        }

        return response()->json([
            'id' => $quizResult->id,
            'user_name' => $quizResult->user->name,
            'user_email' => $quizResult->user->email,
            'total_questions' => $quizResult->total_questions,
            'correct_answers' => $quizResult->correct_answers,
            'score' => $quizResult->score,
            'answers' => $quizResult->answers,
        ]);
    }
}
