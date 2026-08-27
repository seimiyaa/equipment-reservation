<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reservation;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        $equipment = \App\Equipment::findOrFail($request->equipment_id);

        return view('reservation_create', compact('equipment'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'start_hour' => 'required',
            'start_minute' => 'required',
            'end_date' => 'required|date',
            'end_hour' => 'required',
            'end_minute' => 'required',
        ]);

        $startDatetime =
            $request->start_date . ' ' .
            $request->start_hour . ':' .
            $request->start_minute;

        $endDatetime =
            $request->end_date . ' ' .
            $request->end_hour . ':' .
            $request->end_minute;

        if (strtotime($startDatetime) < time()) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '現在時刻より後の日時を指定してください。',
                ]);
        }

        if (strtotime($endDatetime) <= strtotime($startDatetime)) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '終了日時は開始日時より後にしてください。',
                ]);
        }

        $equipment = \App\Equipment::findOrFail($request->equipment_id);

        $startTime = date('H:i:s', strtotime($startDatetime));
        $endTime = date('H:i:s', strtotime($endDatetime));

        if (
            $startTime < $equipment->available_time_start ||
            $endTime > $equipment->available_time_end
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '設備の利用可能時間内で予約してください。',
                ]);
        }

        $overlap = Reservation::where('equipment_id', $request->equipment_id)
            ->where('status', '!=', 2)
            ->where('start_datetime', '<', $endDatetime)
            ->where('end_datetime', '>', $startDatetime)
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'その時間帯はすでに予約されています。',
                ]);
        }

        return view('reservation_confirm', [
            'equipment' => $equipment,
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required',
            'start_datetime' => 'required|date|after_or_equal:now',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $equipment = \App\Equipment::findOrFail($request->equipment_id);

        $startTime = date('H:i:s', strtotime($request->start_datetime));
        $endTime = date('H:i:s', strtotime($request->end_datetime));

        if (
            $startTime < $equipment->available_time_start ||
            $endTime > $equipment->available_time_end
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '設備の利用可能時間内で予約してください。',
                ]);
        }

        $overlap = Reservation::where('equipment_id', $request->equipment_id)
            ->where('status', '!=', 2)
            ->where('start_datetime', '<', $request->end_datetime)
            ->where('end_datetime', '>', $request->start_datetime)
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'その時間帯はすでに予約されています。',
                ]);
        }

        \App\Reservation::create([
            'user_id' => Auth::id(),
            'equipment_id' => $request->equipment_id,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'status' => 0,
        ]);

        return view('reservation_complete');
    }

    public function index()
    {
        $reservations = \App\Reservation::with(['user', 'equipment'])
            ->where('user_id', Auth::id())
            ->orderBy('start_datetime', 'asc')
            ->get();

        return view('reservation_list', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = \App\Reservation::with(['user', 'equipment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('reservation_detail', compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = \App\Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->where('status', 0)
            ->findOrFail($id);

        return view('reservation_edit', compact('reservation'));
    }

    public function editConfirm(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'start_hour' => 'required',
            'start_minute' => 'required',
            'end_date' => 'required|date',
            'end_hour' => 'required',
            'end_minute' => 'required',
        ]);

        $startDatetime =
            $request->start_date . ' ' .
            $request->start_hour . ':' .
            $request->start_minute;

        $endDatetime =
            $request->end_date . ' ' .
            $request->end_hour . ':' .
            $request->end_minute;

        if (strtotime($startDatetime) < time()) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '現在時刻より後の日時を指定してください。',
                ]);
        }

        if (strtotime($endDatetime) <= strtotime($startDatetime)) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '終了日時は開始日時より後にしてください。',
                ]);
        }

        $reservation = \App\Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->where('status', 0)
            ->findOrFail($id);

        $startTime = date('H:i:s', strtotime($startDatetime));
        $endTime = date('H:i:s', strtotime($endDatetime));

        if (
            $startTime < $reservation->equipment->available_time_start ||
            $endTime > $reservation->equipment->available_time_end
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '設備の利用可能時間内で変更してください。',
                ]);
        }

        $overlap = Reservation::where('equipment_id', $reservation->equipment_id)
            ->where('id', '!=', $reservation->id)
            ->where('status', '!=', 2)
            ->where('start_datetime', '<', $endDatetime)
            ->where('end_datetime', '>', $startDatetime)
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'その時間帯はすでに予約されています。',
                ]);
        }

        return view('reservation_edit_confirm', [
            'reservation' => $reservation,
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_datetime' => 'required|date|after_or_equal:now',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $reservation = \App\Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->where('status', 0)
            ->findOrFail($id);

        $startTime = date('H:i:s', strtotime($request->start_datetime));
        $endTime = date('H:i:s', strtotime($request->end_datetime));

        if (
            $startTime < $reservation->equipment->available_time_start ||
            $endTime > $reservation->equipment->available_time_end
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => '設備の利用可能時間内で変更してください。',
                ]);
        }

        $overlap = Reservation::where('equipment_id', $reservation->equipment_id)
            ->where('id', '!=', $reservation->id)
            ->where('status', '!=', 2)
            ->where('start_datetime', '<', $request->end_datetime)
            ->where('end_datetime', '>', $request->start_datetime)
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'その時間帯はすでに予約されています。',
                ]);
        }

        $reservation->update([
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
        ]);

            return redirect()
            ->route('reservation.list');
    }

    public function cancelConfirm($id)
    {
       $reservation = \App\Reservation::with('equipment')
        ->where('user_id', Auth::id())
        ->where('status', 0)
        ->findOrFail($id);

        return view('reservation_cancel_confirm', compact('reservation'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())
            ->where('status', 0)
            ->findOrFail($id);

        $reservation->status = 2;
        $reservation->save();

        return redirect()->route('reservation.detail', $reservation->id);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $overlap = Reservation::where('equipment_id', $request->equipment_id)
            ->where('status', '!=', 2)
            ->where('start_datetime', '<', $request->end_datetime)
            ->where('end_datetime', '>', $request->start_datetime)
            ->exists();

        if ($overlap) {
            return response()->json([
                'available' => false,
                'message' => 'その時間帯はすでに予約されています。',
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'その時間帯は予約できます。',
        ]);
    }
}
