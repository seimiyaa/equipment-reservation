@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約編集</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

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
        </div>
    </div>

    @php
        $start = \Carbon\Carbon::parse($reservation->start_datetime);
        $end = \Carbon\Carbon::parse($reservation->end_datetime);
    @endphp

    <div class="card">
        <div class="card-body">

            <form action="{{ route('reservation.edit_confirm', $reservation->id) }}"
                  method="POST">
                @csrf

                <div class="form-group">
                    <label>利用開始日時</label>

                    <div class="form-row">
                        <div class="col-md-5">
                            <input type="date"
                                   name="start_date"
                                   class="form-control"
                                   value="{{ old('start_date', $start->format('Y-m-d')) }}">
                        </div>

                        <div class="col">
                            <select name="start_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    @php
                                        $hourValue = sprintf('%02d', $hour);
                                    @endphp

                                    <option value="{{ $hourValue }}"
                                        {{ old('start_hour', $start->format('H')) == $hourValue ? 'selected' : '' }}>
                                        {{ $hourValue }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">時</div>

                        <div class="col">
                            <select name="start_minute" class="form-control">
                                <option value="00"
                                    {{ old('start_minute', $start->format('i')) == '00' ? 'selected' : '' }}>
                                    00
                                </option>
                                <option value="30"
                                    {{ old('start_minute', $start->format('i')) == '30' ? 'selected' : '' }}>
                                    30
                                </option>
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">分</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>利用終了日時</label>

                    <div class="form-row">
                        <div class="col-md-5">
                            <input type="date"
                                   name="end_date"
                                   class="form-control"
                                   value="{{ old('end_date', $end->format('Y-m-d')) }}">
                        </div>

                        <div class="col">
                            <select name="end_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    @php
                                        $hourValue = sprintf('%02d', $hour);
                                    @endphp

                                    <option value="{{ $hourValue }}"
                                        {{ old('end_hour', $end->format('H')) == $hourValue ? 'selected' : '' }}>
                                        {{ $hourValue }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">時</div>

                        <div class="col">
                            <select name="end_minute" class="form-control">
                                <option value="00"
                                    {{ old('end_minute', $end->format('i')) == '00' ? 'selected' : '' }}>
                                    00
                                </option>
                                <option value="30"
                                    {{ old('end_minute', $end->format('i')) == '30' ? 'selected' : '' }}>
                                    30
                                </option>
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">分</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    変更内容を確認する
                </button>

                <a href="{{ route('reservation.cancel_confirm', $reservation->id) }}"
                   class="btn btn-danger">
                    予約をキャンセルする
                </a>

                <a href="{{ route('reservation.detail', $reservation->id) }}"
                   class="btn btn-secondary">
                    予約詳細へ戻る
                </a>
            </form>
        </div>
    </div>
</div>
@endsection