<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = \App\Reservation::with(['user', 'equipment'])
            ->orderBy('start_datetime', 'desc')
            ->get();

        return view('admin_reservation_list', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = \App\Reservation::with(['user', 'equipment'])
            ->findOrFail($id);

        return view('admin_reservation_detail', compact('reservation'));
    }
}