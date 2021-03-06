<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';
    protected $id = 'result_id';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'user_id',
        'lesson_id',
        'total_words',
        'minutes',
        'duration',
        'correct_words',
        'incorrect_words',
        'error_words',
        'wpm',
        'accuracy',
        'slowdown',
        'overall_rating',
        'type'
    ];
}
