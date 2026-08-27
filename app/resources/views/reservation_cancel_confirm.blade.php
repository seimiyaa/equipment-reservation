@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約キャンセル確認</h1>

    <div class="alert alert-warning">
        <p class="mb-1">本当にこの予約をキャンセルしますか？</p>
        <small>※キャンセルした予約は元に戻せません</small>
    </div>

    <div class="card mb-4">
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
        </div>
    </div>

    <form action="{{ route('reservation.destroy', $reservation->id) }}"
          method="POST">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-danger">
            キャンセルする
        </button>

        <a href="{{ route('reservation.detail', $reservation->id) }}"
           class="btn btn-secondary">
            予約詳細へ戻る
        </a>
    </form>
</div>
@endsection