<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'student_id',
        'subject',
        'score',
        'grade',
    ];

    public function student()
{
    return $this->belongsTo(Student::class);
}


    // Define relationships if necessary
    /**public function student()
    {
        return $this->belongsTo(User::class, 'student_id'); // Assuming a Student model exists
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id'); // Assuming users table for teachers
    }*/
}

