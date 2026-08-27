@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">設備一覧</h1>

    <form method="GET"
          action="{{ route('equipment.list') }}"
          class="mb-4">

        <div class="form-row">

            <div class="col-md-4">
                <label for="name">設備名</label>
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control"
                       value="{{ request('name') }}"
                       placeholder="設備名を入力">
            </div>

            <div class="col-md-3">
                <label for="category_id">カテゴリ</label>
                <select name="category_id"
                        id="category_id"
                        class="form-control">

                    <option value="">すべて</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="available_time">利用可能時間</label>

                <select name="available_time"
                        id="available_time"
                        class="form-control">

                    <option value="">すべて</option>

                    @for ($hour = 0; $hour < 24; $hour++)
                        @foreach (['00', '30'] as $minute)
                            @php
                                $time = sprintf('%02d:%s', $hour, $minute);
                            @endphp

                            <option value="{{ $time }}"
                                {{ request('available_time') == $time ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endforeach
                    @endfor
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit"
                        class="btn btn-primary btn-block">
                    検索
                </button>
            </div>

        </div>
    </form>

    <div class="row">
        @foreach ($equipments as $equipment)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">

                        @if ($equipment->image_path)
                            <img src="{{ asset('storage/' . $equipment->image_path) }}"
                                 alt="{{ $equipment->name }}"
                                 class="img-fluid mb-3"
                                 style="max-height: 200px;">
                        @endif

                        <h5 class="card-title">
                            {{ $equipment->name }}
                        </h5>

                        <p>
                            <strong>カテゴリ：</strong>
                            {{ $equipment->category->name }}
                        </p>

                        <p>
                            <strong>利用可能時間：</strong>
                            {{ \Carbon\Carbon::parse($equipment->available_time_start)->format('H:i') }}
                            ～
                            {{ \Carbon\Carbon::parse($equipment->available_time_end)->format('H:i') }}
                        </p>

                        <p>
                            <strong>説明：</strong>
                            {{ $equipment->description }}
                        </p>

                        <a href="{{ route('equipment.detail', $equipment->id) }}"
                           class="btn btn-primary">
                            詳細を見る
                        </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection