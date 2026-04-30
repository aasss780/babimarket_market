<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('profile', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:60'],
            'address' => ['nullable', 'string'],
            'store_name' => ['nullable', 'string', 'max:255'],
            'store_description' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $request->user()->update($data);
        return back()->with('success', 'Profile updated');
    }
}
