<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.account.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$request->user()->id],
            'phone' => ['nullable','string','max:30'],
            'current_password' => ['nullable','required_with:password','current_password'],
            'password' => ['nullable','confirmed',Password::min(10)->letters()->numbers()],
        ]);
        unset($data['current_password'], $data['password_confirmation']);
        if (blank($data['password'] ?? null)) unset($data['password']);
        $request->user()->update($data);
        activity_log('account.update', $request->user());
        return back()->with('flash',['type'=>'success','message'=>'Akun diperbarui']);
    }
}
