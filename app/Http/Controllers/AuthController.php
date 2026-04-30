<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Password reset (forgot → reset) is intentionally simplified for local/demo use:
 * no email tokens and no outbound mail. Anyone who knows an account email can set a new password
 * after submitting the forgot form. Do not use this pattern in production.
 */
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        return redirect()->route('password.reset', ['email' => $request->input('email')]);
    }

    public function showResetPasswordForm(Request $request)
    {
        $email = $request->query('email');
        if (! is_string($email) || $email === '' || ! User::where('email', $email)->exists()) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Please enter your email on the forgot password page first.']);
        }

        return view('auth.reset-password', ['email' => $email]);
    }

    public function handleResetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();
        // Stored hashed via User model `password` cast (equivalent to Hash::make for persistence).
        $user->password = $data['password'];
        $user->save();

        return redirect()->route('login')->with('success', 'Password updated successfully. Please login.');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'role' => ['required', 'in:customer,seller'],
        ]);

        $user = User::create([
            ...$data,
            'status' => 'active',
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        return $this->redirectByRole($user);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
        }

        if (Auth::user()?->status === 'blocked') {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account is blocked.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        return $this->redirectByRole(Auth::user());
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'seller' => redirect()->route('seller.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
