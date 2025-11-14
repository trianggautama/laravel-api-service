@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">User Profile</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Member Since</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-4">API Key</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Your API Key</label>
                        <div class="flex items-center space-x-2">
                            <input type="text" 
                                   value="{{ $user->api_key }}" 
                                   readonly
                                   class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-sm font-mono"
                                   id="apiKey">
                            <button onclick="copyApiKey()" 
                                    class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md text-sm font-medium">
                                Copy
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Keep this key secure. Use it to authenticate API requests.
                        </p>
                    </div>
                    
                    <form action="{{ route('profile.regenerate-api-key') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to generate a new API key? The old key will no longer work.')"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md text-sm">
                            Generate New API Key
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">How to Use Your API Key</h3>
            <div class="text-sm text-gray-700 space-y-2">
                <p>Include your API key in the request headers when making API calls:</p>
                <div class="bg-gray-800 text-green-400 p-3 rounded-md font-mono text-xs">
                    <div>Authorization: Bearer {{ $user->api_key }}</div>
                    <div>or</div>
                    <div>X-API-Key: {{ $user->api_key }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyApiKey() {
    const apiKeyInput = document.getElementById('apiKey');
    apiKeyInput.select();
    apiKeyInput.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(apiKeyInput.value).then(function() {
        // Show success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.add('bg-green-500', 'text-white');
        button.classList.remove('bg-gray-200', 'text-gray-700');
        
        setTimeout(function() {
            button.textContent = originalText;
            button.classList.remove('bg-green-500', 'text-white');
            button.classList.add('bg-gray-200', 'text-gray-700');
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
    });
}
</script>
@endsection
