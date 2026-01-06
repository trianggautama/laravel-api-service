<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    /**
     * Get 8 random questions with their options.
     * Requires valid API key in Authorization header.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRandom(Request $request): JsonResponse
    {
        // Get 8 random questions with their options
        $questions = Question::with('options')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return response()->json([
            'success' => true,
            'data' => QuestionResource::collection($questions),
            'message' => 'Random questions retrieved successfully',
            'count' => $questions->count()
        ]);
    }
}
