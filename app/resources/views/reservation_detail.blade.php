@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約詳細</h1>

    <div class="card">
        <div class="card-body">

            @if ($reservation->equipment->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $reservation->equipment->image_path) }}"
                         alt="{{ $reservation->equipment->name }}"
                         class="img-fluid"
                         style="max-height: 300px;">
                </div>
            @endif

            <p>
                <strong>設備名：</strong>
                {{ $reservation->equipment->name }}
            </p>

            <p>
                <strong>カテゴリ：</strong>
                {{ $reservation->equipment->category->name }}
            </p>

            <p>
                <strong>説明：</strong>
                {{ $reservation->equipment->description }}
            </p>

            <p>
                <strong>利用開始日時：</strong>
                {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y/m/d H:i') }}
            </p>

            <p>
                <strong>利用終了日時：</strong>
                {{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y/m/d H:i') }}
            </p>

            <p>
                <strong>予約状況：</strong>

                @if ($reservation->status == 0)
                    <span class="badge badge-primary">予約中</span>
                @elseif ($reservation->status == 1)
                    <span class="badge badge-secondary">利用済</span>
                @elseif ($reservation->status == 2)
                    <span class="badge badge-danger">キャンセル済</span>
                @endif
            </p>

            @if ($reservation->status == 0)
                <a href="{{ route('reservation.edit', $reservation->id) }}"
                   class="btn btn-primary">
                    予約を編集する
                </a>

                <a href="{{ route('reservation.cancel_confirm', $reservation->id) }}"
                   class="btn btn-danger">
                    予約をキャンセルする
                </a>
            @endif

            <a href="{{ route('reservation.list') }}"
               class="btn btn-secondary">
                予約一覧へ戻る
            </a>

        </div>
    </div>
</div>
@endsection