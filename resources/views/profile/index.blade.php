@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">User Profile</h2>
            <button onclick="toggleEditMode()" id="editBtn" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm font-medium">
                Edit Profile
            </button>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-md">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- View Mode -->
        <div id="viewMode" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Photo -->
                <div class="md:col-span-1">
                    <div class="flex flex-col items-center">
                        @if($user->photo)
                            <img src="{{ asset('storage/photos/' . $user->photo) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NPM</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->npm ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($user->gender)
                                    {{ ucfirst($user->gender) }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Birth Place</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->birth_place ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Birth Date</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($user->birth_date)
                                    {{ $user->birth_date->format('F j, Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->address ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Key Section -->
            <div class="mt-6">
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

            <div class="p-4 bg-blue-50 rounded-lg">
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

        <!-- Edit Mode -->
        <div id="editMode" class="hidden">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Photo Upload -->
                    <div class="md:col-span-1">
                        <div class="flex flex-col items-center space-y-4">
                            <div class="relative">
                                @if($user->photo)
                                    <img src="{{ asset('storage/photos/' . $user->photo) }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                                <input type="file" 
                                       name="photo" 
                                       id="photo" 
                                       accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-medium
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                                <p class="mt-1 text-xs text-gray-500">Max size: 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ $user->email }}"
                                       readonly
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="npm" class="block text-sm font-medium text-gray-700">NPM</label>
                                <input type="text" 
                                       name="npm" 
                                       id="npm" 
                                       value="{{ old('npm', $user->npm) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" 
                                        id="gender" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="birth_place" class="block text-sm font-medium text-gray-700">Birth Place</label>
                                <input type="text" 
                                       name="birth_place" 
                                       id="birth_place" 
                                       value="{{ old('birth_place', $user->birth_place) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                                <input type="date" 
                                       name="birth_date" 
                                       id="birth_date" 
                                       value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" 
                                          id="address" 
                                          rows="3"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="toggleEditMode()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm font-medium">
                        Save Changes
                    </button>
                </div>
            </form>
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

function toggleEditMode() {
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    const editBtn = document.getElementById('editBtn');
    
    if (viewMode.classList.contains('hidden')) {
        viewMode.classList.remove('hidden');
        editMode.classList.add('hidden');
        editBtn.textContent = 'Edit Profile';
    } else {
        viewMode.classList.add('hidden');
        editMode.classList.remove('hidden');
        editBtn.textContent = 'Cancel Edit';
    }
}

// Photo preview
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('#editMode img');
            if (img) {
                img.src = e.target.result;
            } else {
                const placeholder = document.querySelector('#editMode .w-32.h-32.rounded-full');
                if (placeholder) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-32 h-32 rounded-full object-cover border-4 border-gray-200';
                    img.alt = 'Preview';
                    placeholder.parentNode.replaceChild(img, placeholder);
                }
            }
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
