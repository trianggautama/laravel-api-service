@extends('layouts.app')

@section('title', 'My Quiz Results')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Quiz Results</h1>
        <a href="{{ route('posts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
            ← Kembali
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        @if($quizResults->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pertanyaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jawaban Benar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($quizResults as $result)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">#{{ $result->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $result->total_questions }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $result->correct_answers }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($result->score >= 80)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $result->score }}%</span>
                                @elseif($result->score >= 60)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $result->score }}%</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $result->score }}%</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $result->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="showDetails({{ $result->id }})" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $quizResults->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada quiz</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum mengikuti quiz manapun.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal untuk detail quiz -->
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Quiz</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-2" id="modal-content">
                <!-- Content akan di-load via JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
    function showDetails(resultId) {
        // Fetch quiz result details
        fetch(`/quiz-results/${resultId}`)
            .then(response => response.json())
            .then(data => {
                const content = document.getElementById('modal-content');
                content.innerHTML = `
                    <div class="mb-4">
                        <p class="text-sm text-gray-600"><strong>Skor:</strong> ${data.score}%</p>
                        <p class="text-sm text-gray-600"><strong>Jawaban Benar:</strong> ${data.correct_answers}/${data.total_questions}</p>
                    </div>
                    <div class="space-y-3">
                        ${data.answers.map((answer, index) => `
                            <div class="p-3 rounded ${answer.is_correct ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'}">
                                <p class="font-medium text-gray-900 mb-2">${index + 1}. ${answer.question_text}</p>
                                <p class="text-sm text-gray-600 mb-1"><strong>Jawaban Anda:</strong> ${answer.user_answer}</p>
                                <p class="text-sm text-gray-600"><strong>Jawaban Benar:</strong> ${answer.correct_answer}</p>
                                <p class="text-xs mt-1 ${answer.is_correct ? 'text-green-600' : 'text-red-600'}">
                                    ${answer.is_correct ? '✓ Benar' : '✗ Salah'}
                                </p>
                            </div>
                        `).join('')}
                    </div>
                `;
                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat detail quiz');
            });
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection
