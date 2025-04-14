<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'qualification',
        'join_date',
        'phone',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classSubjects()
    {
        return $this->hasMany(ClassSubjectTeacher::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject_teacher', 'teacher_profile_id', 'class_id')
            ->withPivot('subject_id')
            ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'teacher_profile_id', 'subject_id')
            ->withPivot('class_id')
            ->withTimestamps();
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}