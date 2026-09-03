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