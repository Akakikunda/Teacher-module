<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth; // Add this line

class TeacherController extends Controller
{
    public function index()
    {
        /*$teacher = Auth::user(); // Get logged-in teacher
         // Return the view with the data
         return view('teacher.dashboard', compact('teacher', 'assignments', 'marks', 'messages'));
**/ return view('dashboard'); // You can change this to 'teacher.dashboard' if you make a new view

        
    }
}






