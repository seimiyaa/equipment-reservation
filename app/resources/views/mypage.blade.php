@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">マイページ</h1>

    <p>マイページです。</p>

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

    @foreach ($pastReservations as $reservation)
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
                   class="btn btn-secondary">
                    詳細を見る
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection