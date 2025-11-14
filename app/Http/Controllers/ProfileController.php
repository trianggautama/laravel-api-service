<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Generate a new API key for the user.
     */
    public function regenerateApiKey(Request $request)
    {
        $user = Auth::user();
        $newApiKey = $user->generateApiKey();
        
        return back()->with('success', 'New API key generated successfully!');
    }
}
