
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
});

Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/teacher/students', [StudentController::class, 'store'])->name('students.store');
});
Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
});

Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
});

Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');

Route::get('/icons', function () {
    return view('pages.icons');
})->name('pages.icons');

Route::get('/maps', function () {
    return view('pages.maps');
})->name('pages.maps');

Route::get('/notifications', function () {
    return view('pages.notifications');
})->name('pages.notifications');

Route::get('/tables', function () {
    return view('pages.tables');
})->name('pages.tables');

Route::get('/typography', function () {
    return view('pages.typography');
})->name('pages.typography');

Route::get('/rtl', function () {
    return view('pages.rtl');
})->name('pages.rtl');

Route::get('/upgrade', function () {
    return view('pages.upgrade');
})->name('pages.upgrade');

Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');

Route::get('/marks/create', [MarkController::class, 'create'])->name('marks.create');
Route::post('/marks/store', [MarkController::class, 'store'])->name('marks.store');

Route::resource('marks', MarkController::class);


Route::get('/teacher/dashboard', function () {
    return view('dashboard'); // make sure this matches the filename
});


Route::get('/students', [StudentController::class, 'index'])->name('students.index');

require __DIR__.'/auth.php';




