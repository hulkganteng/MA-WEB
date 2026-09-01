<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AlumniSubmission;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        return view('public.alumni.index', ['alumni' => Alumni::public()->orderBy('order')->latest('graduation_year')->paginate(12)]);
    }

    public function create()
    {
        return view('public.alumni.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'graduation_year' => ['nullable', 'integer', 'min:1950', 'max:'.now()->year], 'email' => ['required', 'email', 'max:255'], 'phone' => ['nullable', 'string', 'max:30'], 'university' => ['nullable', 'string', 'max:255'], 'occupation' => ['nullable', 'string', 'max:255'], 'testimonial' => ['nullable', 'string', 'max:1500']]);
        AlumniSubmission::create($data + ['ip_address' => $request->ip(), 'status' => 'pending']);

        return back()->with('flash', ['type' => 'success', 'message' => 'Data alumni terkirim dan menunggu verifikasi']);
    }
}
