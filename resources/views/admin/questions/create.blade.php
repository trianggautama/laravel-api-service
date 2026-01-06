@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Question</h1>
            <p class="text-gray-600 mt-1">Add a new quiz question with answer options</p>
        </div>
        <a href="{{ route('admin.questions.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Questions
        </a>
    </div>

    <!-- Form Card -->
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.questions.store') }}">
                    @csrf

                    <!-- Question Text -->
                    <div class="mb-6">
                        <label for="question_text" class="block text-sm font-medium text-gray-700 mb-2">
                            Question Text
                        </label>
                        <textarea 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('question_text') border-red-500 @enderror transition-colors duration-200" 
                            id="question_text" 
                            name="question_text" 
                            rows="4"
                            placeholder="Enter your question here..."
                            required>{{ old('question_text') }}</textarea>
                        @error('question_text')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Answer Options -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Answer Options
                        </label>
                        <div id="options-container" class="space-y-3">
                            <div class="option-item">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-gray-50">
                                        <input type="radio" name="is_correct" value="0" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    </div>
                                    <input type="text" 
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" 
                                           name="options[]" 
                                           placeholder="Option 1" 
                                           required>
                                </div>
                            </div>
                            <div class="option-item">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-gray-50">
                                        <input type="radio" name="is_correct" value="1" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    </div>
                                    <input type="text" 
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" 
                                           name="options[]" 
                                           placeholder="Option 2" 
                                           required>
                                </div>
                            </div>
                        </div>
                        <button type="button" 
                                class="mt-3 inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors duration-200" 
                                id="add-option">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Option
                        </button>
                    </div>

                    <!-- Info Alert -->
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Select the radio button next to the correct answer option.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.questions.index') }}" 
                           class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition-colors duration-200">
                            Save Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let optionCount = 2;

document.getElementById('add-option').addEventListener('click', function() {
    optionCount++;
    const container = document.getElementById('options-container');
    const optionItem = document.createElement('div');
    optionItem.className = 'option-item';
    optionItem.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-gray-50">
                <input type="radio" name="is_correct" value="${optionCount - 1}" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
            </div>
            <input type="text" 
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" 
                   name="options[]" 
                   placeholder="Option ${optionCount}" 
                   required>
            <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 remove-option">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    container.appendChild(optionItem);

    optionItem.querySelector('.remove-option').addEventListener('click', function() {
        if (optionCount > 2) {
            optionCount--;
            optionItem.remove();
            updateRadioValues();
        } else {
            alert('You must have at least 2 options');
        }
    });
});

function updateRadioValues() {
    const radios = document.querySelectorAll('input[name="is_correct"]');
    radios.forEach((radio, index) => {
        radio.value = index;
    });
}
</script>
@endsection
