<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Equipment::with('category')
            ->where('del_flg', false);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('available_time')) {
            $query->where('available_time_start', '<=', $request->available_time)
                ->where('available_time_end', '>=', $request->available_time);
        }

        $equipments = $query
            ->orderBy('id', 'asc')
            ->get();

        $categories = \App\Category::all();

        return view('equipment_list', compact('equipments', 'categories'));
    }

    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);

        return view('equipment_detail', compact('equipment'));
    }

    public function calendar(Request $request, $id)
    {
        $year = $request->year;
        $month = $request->month;

        $reservations = \App\Reservation::where('equipment_id', $id)
            ->where('status', '!=', 2)
            ->whereYear('start_datetime', $year)
            ->whereMonth('start_datetime', $month)
            ->orderBy('start_datetime', 'asc')
            ->get();

        return response()->json([
            'reservations' => $reservations,
        ]);
    }
}
