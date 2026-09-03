<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $resetUrl = route('password.reset.form', ['token' => $token]);

        Mail::send([], [], function ($message) use ($user, $resetUrl) {
            $message->to($user->email)
                ->subject('パスワード再設定')
                ->setBody(
                    '<p>パスワード再設定はこちらから行ってください。</p>' .
                    '<p><a href="' . $resetUrl . '">パスワードを再設定する</a></p>',
                    'text/html'
                );
        });

        return view('password_reset_sent', compact('user'));
    }

    public function showResetForm($token)
    {
        $user = \App\User::where('reset_token', $token)->firstOrFail();

        return view('password_reset_form', compact('user', 'token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = \App\User::where('reset_token', $request->token)->firstOrFail();

        $user->password = bcrypt($request->password);
        $user->reset_token = null;
        $user->save();

        return redirect()->route('login')
            ->with('status', 'パスワードを変更しました。');
    }
}
