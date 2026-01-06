@extends('layouts.app')

@section('title', 'Admin - Posts')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Posts</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
            ← Kembali ke Dashboard
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        @if($posts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ringkasan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($posts as $post)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">#{{ $post->id }}</td>
                            <td class="px-6 py-4 text-gray-700 font-medium">{{ $post->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $post->user->name }}</td>
                            <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ Str::limit($post->content, 100) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $post->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                @if(auth()->id() === $post->user_id)
                                    <a href="{{ route('posts.edit', $post) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-600">Belum ada post.</p>
        @endif
    </div>
</div>
@endsection
