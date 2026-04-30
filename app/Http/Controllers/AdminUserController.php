<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.users', ['users' => User::latest()->get()]);
    }

    public function toggleStatus(User $user)
    {
        $user->update(['status' => $user->status === 'active' ? 'blocked' : 'active']);
        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
