<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('password_reset_request');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = \App\User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => '登録されているメールアドレスが見つかりません。',
                ]);
        }

        $token = bin2hex(random_bytes(32));

        $user->reset_token = $token;
        $user->save();

        return view('password_reset_sent', compact('user'));
    }

    public function showResetForm($token)
    {
        $user = \App\User::where('reset_token', $token)->firstOrFail();

        return view('password_reset_form', compact('user', 'token'));
    }
}
