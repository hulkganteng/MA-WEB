<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Teacher;

class GuruController extends Controller
{
    public function index()
    {
        return view('public.teachers.index', ['teachers' => Teacher::public()->orderBy('order')->orderBy('name')->get()->groupBy('type')]);
    }
}
