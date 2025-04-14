<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'grade_level',
        'academic_year',
        'description',
    ];

    public function teachers()
    {
        return $this->belongsToMany(TeacherProfile::class, 'class_subject_teacher', 'class_id', 'teacher_profile_id')
            ->withPivot('subject_id')
            ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'class_id', 'subject_id')
            ->withPivot('teacher_profile_id')
            ->withTimestamps();
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}