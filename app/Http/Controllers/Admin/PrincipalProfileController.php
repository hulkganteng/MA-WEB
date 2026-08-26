<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrincipalProfileController extends Controller
{
    public function edit()
    {
        $settings = collect(['principal.name', 'principal.position', 'principal.photo', 'principal.speech'])
            ->mapWithKeys(fn ($key) => [$key => Setting::get($key)]);

        return view('admin.profile.principal', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'speech' => ['required', 'string', 'max:10000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);
        Setting::set('principal.name', $data['name'], 'principal');
        Setting::set('principal.position', $data['position'], 'principal');
        Setting::set('principal.speech', clean($data['speech']), 'principal');
        if ($request->hasFile('photo')) {
            if ($old = Setting::get('principal.photo')) {
                Storage::disk('public')->delete($old);
            }
            Setting::set('principal.photo', $request->file('photo')->store('settings', 'public'), 'principal');
        }
        activity_log('profile.principal.update', null, ['name' => $data['name']]);

        return redirect()->route('admin.profile.index')->with('flash', ['type' => 'success', 'message' => 'Sambutan kepala madrasah diperbarui']);
    }
}
