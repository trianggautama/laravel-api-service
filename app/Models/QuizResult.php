<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_questions',
        'correct_answers',
        'score',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    /**
     * Get the user that owns the quiz result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
