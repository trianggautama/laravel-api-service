@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">{{ $post->title }}</h2>
            <div class="flex items-center space-x-2">
                @if ($post->user_id === Auth::id())
                    <a href="{{ route('posts.edit', $post->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                @endif
                <a href="{{ route('posts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded text-sm">Back to Posts</a>
            </div>
        </div>

        <div class="px-6 py-4">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-6">
                <p class="text-sm text-gray-500">
                    By <span class="font-medium text-gray-700">{{ $post->user->name }}</span> on {{ $post->created_at->format('F d, Y \a\t g:i A') }}
                    @if ($post->updated_at != $post->created_at)
                        <br>Last updated: {{ $post->updated_at->format('F d, Y \a\t g:i A') }}
                    @endif
                </p>
            </div>

            <div class="prose max-w-none">
                <p class="whitespace-pre-wrap text-gray-700 leading-relaxed">{{ $post->body }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
