<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminEquipmentController extends Controller
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

        $equipments = $query
            ->orderBy('id', 'asc')
            ->get();

        $categories = \App\Category::all();

        return view('admin_equipment_list', compact('equipments', 'categories'));
    }

    public function create()
    {
        $categories = \App\Category::all();

        return view('admin_equipment_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'start_hour' => 'required',
            'start_minute' => 'required',
            'end_hour' => 'required',
            'end_minute' => 'required',
            'description' => 'nullable',
        ]);

        $availableTimeStart = $request->start_hour . ':' . $request->start_minute;
        $availableTimeEnd = $request->end_hour . ':' . $request->end_minute;

        $imagePath = $request->file('image')
            ->store('equipments', 'public');

        \App\Equipment::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image_path' => $imagePath,
            'available_time_start' => $availableTimeStart,
            'available_time_end' => $availableTimeEnd,
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'start_hour' => 'required',
            'start_minute' => 'required',
            'end_hour' => 'required',
            'end_minute' => 'required',
            'description' => 'nullable',
        ]);

        $availableTimeStart = $request->start_hour . ':' . $request->start_minute;
        $availableTimeEnd = $request->end_hour . ':' . $request->end_minute;

        $equipment = \App\Equipment::findOrFail($id);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'available_time_start' => $availableTimeStart,
            'available_time_end' => $availableTimeEnd,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')
                ->store('equipments', 'public');
        }

        $equipment->update($data);

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
