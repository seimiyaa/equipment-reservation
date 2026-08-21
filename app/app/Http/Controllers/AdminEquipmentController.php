<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminEquipmentController extends Controller
{
    public function index()
    {
        $equipments = \App\Equipment::with('category')
            ->where('del_flg', false)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin_equipment_list', compact('equipments'));
    }

    public function create()
    {
        $categories = \App\Category::all();

        return view('admin_equipment_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'available_time_start' => 'required',
            'available_time_end' => 'required|after:available_time_start',
            'description' => 'nullable',
        ]);

        \App\Equipment::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'available_time_start' => $request->available_time_start,
            'available_time_end' => $request->available_time_end,
            'description' => $request->description,
            'del_flg' => false,
        ]);

        return redirect()->route('admin.equipments');
    }

    public function edit($id)
    {
        $equipment = \App\Equipment::findOrFail($id);
        $categories = \App\Category::all();

        return view('admin_equipment_edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'available_time_start' => 'required',
            'available_time_end' => 'required|after:available_time_start',
            'description' => 'nullable',
        ]);

        $equipment = \App\Equipment::findOrFail($id);

        $equipment->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'available_time_start' => $request->available_time_start,
            'available_time_end' => $request->available_time_end,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.equipments');
    }

    public function deleteConfirm($id)
    {
        $equipment = \App\Equipment::findOrFail($id);

        return view('admin_equipment_delete_confirm', compact('equipment'));
    }

    public function destroy($id)
    {
        $equipment = \App\Equipment::findOrFail($id);

        $equipment->del_flg = true;
        $equipment->save();

        return redirect()->route('admin.equipments');
    }
}
