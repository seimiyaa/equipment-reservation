@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約変更確認</h1>

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
                <strong>変更後の利用開始日時：</strong>
                {{ \Carbon\Carbon::parse($start_datetime)->format('Y/m/d H:i') }}
            </p>

            <p>
                <strong>変更後の利用終了日時：</strong>
                {{ \Carbon\Carbon::parse($end_datetime)->format('Y/m/d H:i') }}
            </p>
        </div>
    </div>

    <form action="{{ route('reservation.update', $reservation->id) }}"
          method="POST">
        @csrf
        @method('PUT')

        <input type="hidden"
               name="start_datetime"
               value="{{ $start_datetime }}">

        <input type="hidden"
               name="end_datetime"
               value="{{ $end_datetime }}">

        <button type="submit"
                class="btn btn-primary">
            変更する
        </button>

        <a href="{{ route('reservation.list') }}"
           class="btn btn-secondary">
            予約一覧へ戻る
        </a>

        <a href="{{ route('reservation.edit', $reservation->id) }}"
           class="btn btn-outline-secondary">
            編集画面に戻る
        </a>
    </form>
</div>
@endsection