<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::where('del_flg', false)->get();

        return view('equipment_list', compact('equipments'));
    }

    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);

        return view('equipment_detail', compact('equipment'));
    }
}
