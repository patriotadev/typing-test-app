<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $id = 'course_id';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['course_name'];
}