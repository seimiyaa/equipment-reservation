@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約確認</h1>

    <div class="card mb-4">
        <div class="card-body">

            @if ($equipment->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $equipment->image_path) }}"
                         alt="{{ $equipment->name }}"
                         class="img-fluid"
                         style="max-height: 300px;">
                </div>
            @endif

            <p>
                <strong>設備名：</strong>
                {{ $equipment->name }}
            </p>

            <p>
                <strong>カテゴリ：</strong>
                {{ $equipment->category->name }}
            </p>

            <p>
                <strong>説明：</strong>
                {{ $equipment->description }}
            </p>

            <p>
                <strong>利用開始日時：</strong>
                {{ \Carbon\Carbon::parse($start_datetime)->format('Y/m/d H:i') }}
            </p>

            <p>
                <strong>利用終了日時：</strong>
                {{ \Carbon\Carbon::parse($end_datetime)->format('Y/m/d H:i') }}
            </p>
        </div>
    </div>

    <form action="{{ route('reservation.store') }}" method="POST">
        @csrf

        <input type="hidden"
               name="equipment_id"
               value="{{ $equipment->id }}">

        <input type="hidden"
               name="start_datetime"
               value="{{ $start_datetime }}">

        <input type="hidden"
               name="end_datetime"
               value="{{ $end_datetime }}">

        <button type="submit" class="btn btn-primary">
            予約確定
        </button>

        <a href="{{ route('reservation.create', ['equipment_id' => $equipment->id]) }}"
           class="btn btn-secondary">
            入力画面に戻る
        </a>
    </form>
</div>
@endsection