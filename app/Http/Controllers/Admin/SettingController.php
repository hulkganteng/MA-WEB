<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Rules\SafeMapsUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private const FIELDS = [
        'site.name', 'site.tagline', 'site.academic_year', 'site.copyright',
        'contact.address', 'contact.email', 'contact.phone', 'contact.whatsapp', 'contact.maps_url', 'contact.hours',
        'hero.title', 'hero.subtitle', 'principal.name', 'principal.position', 'principal.speech',
        'seo.default_title', 'seo.default_description', 'whatsapp.number', 'whatsapp.message',
    ];

    public function edit()
    {
        $settings = Setting::whereIn('key', self::FIELDS)->pluck('value', 'key');

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['required', 'string', 'max:255'],
            'academic_year' => ['nullable', 'string', 'max:20'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'maps_url' => ['nullable', 'url', 'max:1000', new SafeMapsUrl],
            'hours' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:500'],
            'principal_name' => ['nullable', 'string', 'max:255'],
            'principal_position' => ['nullable', 'string', 'max:255'],
            'principal_speech' => ['nullable', 'string', 'max:5000'],
            'seo_title' => ['required', 'string', 'max:255'],
            'seo_description' => ['required', 'string', 'max:320'],
            'whatsapp_message' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:512'],
            'principal_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);
        $map = ['site.name' => 'site_name', 'site.tagline' => 'site_tagline', 'site.academic_year' => 'academic_year', 'site.copyright' => 'copyright', 'contact.address' => 'address', 'contact.email' => 'email', 'contact.phone' => 'phone', 'contact.whatsapp' => 'whatsapp', 'contact.maps_url' => 'maps_url', 'contact.hours' => 'hours', 'hero.title' => 'hero_title', 'hero.subtitle' => 'hero_subtitle', 'principal.name' => 'principal_name', 'principal.position' => 'principal_position', 'principal.speech' => 'principal_speech', 'seo.default_title' => 'seo_title', 'seo.default_description' => 'seo_description', 'whatsapp.number' => 'whatsapp', 'whatsapp.message' => 'whatsapp_message'];
        foreach ($map as $key => $field) {
            Setting::set($key, $data[$field] ?? null, str($key)->before('.')->toString());
        }
        foreach (['logo' => 'site.logo', 'favicon' => 'site.favicon', 'principal_photo' => 'principal.photo'] as $field => $key) {
            if ($request->hasFile($field)) {
                $old = Setting::get($key);
                if ($old) {
                    Storage::disk('public')->delete($old);
                } Setting::set($key, $request->file($field)->store('settings', 'public'), str($key)->before('.')->toString());
            }
        }
        activity_log('settings.update', null, ['keys' => array_keys($map)]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Pengaturan website diperbarui']);
    }
}
