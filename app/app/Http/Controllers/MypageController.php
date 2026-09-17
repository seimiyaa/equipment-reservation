<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        \App\Reservation::where('user_id', Auth::id())
            ->where('status', 0)
            ->where('end_datetime', '<', now())
            ->update([
                'status' => 1,
            ]);

        $upcomingReservations = \App\Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->where('status', 0)
            ->whereDate('start_datetime', '>', now()->toDateString())
            ->orderBy('start_datetime', 'asc')
            ->get();

        $pastReservations = \App\Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->where('status', '!=', 2)
            ->where(function ($query) {
            $query->where('status', 1)
            ->orWhere('start_datetime', '<', now());
            })
            ->orderBy('start_datetime', 'desc')
            ->get();

        $todayReservations = \App\Reservation::with('equipment')
            ->where('status', 0)
            ->whereDate('start_datetime', now()->toDateString())
            ->orderBy('start_datetime', 'asc')
            ->get()
            ->groupBy('equipment_id');

        $equipments = \App\Equipment::where('del_flg', false)
            ->orderBy('name', 'asc')
            ->get();

        return view('mypage', compact(
            'upcomingReservations',
            'pastReservations',
            'todayReservations',
            'equipments'
        ));
    }
}
