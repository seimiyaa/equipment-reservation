<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = \App\User::where('del_flg', false)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin_user_list', compact('users'));
    }

    public function create()
    {
        return view('admin_user_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:0,1',
        ], [
            'name.required' => 'ユーザー名を入力してください。',
            'name.max' => 'ユーザー名は50文字以内で入力してください。',

            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスはすでに登録されています。',

            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',

            'role.required' => '権限を選択してください。',
            'role.in' => '権限の値が正しくありません。',
        ]);

        \App\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'del_flg' => false,
        ]);

        return redirect()->route('admin.users');
    }

    public function deleteConfirm($id)
    {
        $user = \App\User::findOrFail($id);

        return view('admin_user_delete_confirm', compact('user'));
    }

    public function destroy($id)
    {
        $user = \App\User::findOrFail($id);

        $user->del_flg = true;
        $user->save();

        return redirect()->route('admin.users');
    }

    public function report()
    {
        $users = \App\User::withCount('reservations')
            ->with([
                'reservations' => function ($query) {
                    $query->orderBy('start_datetime', 'desc');
                }
            ])
            ->where('del_flg', false)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin_user_report', compact('users'));
    }
}