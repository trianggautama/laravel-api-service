<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * Only returns posts belonging to the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->input('authenticated_user');
        
        $posts = Post::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => PostResource::collection($posts),
            'message' => 'Posts retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->input('authenticated_user');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => new PostResource($post->load('user')),
            'message' => 'Post created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     * Only returns the post if it belongs to the authenticated user.
     */
    public function show(Request $request, Post $post): JsonResponse
    {
        $user = $request->input('authenticated_user');
        
        if ($post->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'error' => 'Forbidden',
                'message' => 'You can only view your own posts'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => new PostResource($post->load('user')),
            'message' => 'Post retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     * Only updates the post if it belongs to the authenticated user.
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $user = $request->input('authenticated_user');
        
        if ($post->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'error' => 'Forbidden',
                'message' => 'You can only update your own posts'
            ], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'data' => new PostResource($post->load('user')),
            'message' => 'Post updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * Only deletes the post if it belongs to the authenticated user.
     */
    public function destroy(Request $request, Post $post): JsonResponse
    {
        $user = $request->input('authenticated_user');
        
        if ($post->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'error' => 'Forbidden',
                'message' => 'You can only delete your own posts'
            ], 403);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }
}
