<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the Authorization header
        $authorization = $request->header('Authorization');
        
        // Check if Authorization header exists and starts with 'Bearer '
        if (!$authorization || !str_starts_with($authorization, 'Bearer ')) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Bearer token required'
            ], 401);
        }
        
        // Extract the token
        $token = substr($authorization, 7);
        
        // Find user by API key
        $user = User::where('api_key', $token)->first();
        
        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid API key'
            ], 401);
        }
        
        // Add the authenticated user to the request
        $request->merge(['authenticated_user' => $user]);
        
        return $next($request);
    }
}
