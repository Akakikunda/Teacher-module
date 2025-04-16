<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**public function index ()
    {
        //return view('dashboard'); // Make sure you have resources/views/dashboard.blade.php
        return view('dashboard', ['pageSlug' => 'dashboard']);
    }
} */
public function index()
{
    return view('dashboard'); // again, make sure it's 'resources/views/dashboard.blade.php'
}
}

