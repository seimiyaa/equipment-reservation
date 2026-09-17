@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">マイページ</h1>

    <p>マイページです。</p>

    <h2 class="mt-4">今日の設備・備品予約状況</h2>

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="thead-light">
            <tr>
                <th>設備・備品名</th>
                <th>状態</th>
                <th>予約時間</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($equipments as $equipment)
                @php
                    $reservations = $todayReservations->get($equipment->id);
                @endphp

                <tr>
                    <td>
                        <a href="{{ route('equipment.detail', $equipment->id) }}">
                            {{ $equipment->name }}
                        </a>
                    </td>

                    <td>
                        @if ($reservations && $reservations->count())
                            <span class="badge badge-danger">
                                予約あり
                            </span>
                        @else
                            <span class="badge badge-success">
                                空き
                            </span>
                        @endif
                    </td>

                    <td>
                        @if ($reservations && $reservations->count())
                            @foreach ($reservations as $reservation)
                                <div>
                                    {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('H:i') }}
                                    ～
                                    {{ \Carbon\Carbon::parse($reservation->end_datetime)->format('H:i') }}
                                </div>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <h2 class="mt-4">今後の利用予定</h2>

    @foreach ($upcomingReservations as $reservation)
        <div class="card mb-3">
            <div class="card-body">
                <p>設備名：{{ $reservation->equipment->name }}</p>
                <p>
                    開始：
                    {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y/m/d H:i') }}
                </p>

                <p>
                    終了：
                    {{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y/m/d H:i') }}
                </p>

                <a href="{{ route('reservation.detail', $reservation->id) }}"
                   class="btn btn-primary">
                    詳細を見る
                </a>
            </div>
        </div>
    @endforeach

    <h2 class="mt-4">過去の利用履歴</h2>

    <div class="mt-4">
        <a href="{{ route('reservation.list') }}" class="btn btn-outline-secondary">
            予約一覧・利用履歴を見る
        </a>
    </div>
</div>
@endsection