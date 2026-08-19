<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $upcomingReservations = \App\Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->where('status', 0)
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime', 'asc')
            ->get();

        $pastReservations = \App\Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->where(function ($query) {
            $query->where('status', 1)
            ->orWhere('start_datetime', '<', now());
            })
            ->orderBy('start_datetime', 'desc')
            ->get();

        return view('mypage', compact('upcomingReservations', 'pastReservations'));
    }
}
