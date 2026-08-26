<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\SocialLink;
use Illuminate\Http\Request;
class ContactController extends Controller {
    public function index() { return view('public.contact', ['socialLinks' => SocialLink::where('is_active', true)->whereNotNull('url')->get()]); }
    public function store(Request $request) { $data = $request->validate(['name' => ['required','string','max:255'], 'email' => ['required','email','max:255'], 'phone' => ['nullable','string','max:30'], 'subject' => ['required','string','max:255'], 'message' => ['required','string','max:3000']]); ContactMessage::create($data + ['ip_address' => $request->ip()]); return back()->with('flash', ['type' => 'success', 'message' => 'Pesan Anda telah diterima']); }
}
