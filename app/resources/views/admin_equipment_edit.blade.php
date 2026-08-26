@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">設備編集</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.equipment.update', $equipment->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>現在の設備画像</label><br>

                    @if ($equipment->image_path)
                        <img src="{{ asset('storage/' . $equipment->image_path) }}"
                             alt="{{ $equipment->name }}"
                             width="200"
                             class="mb-2">
                    @else
                        <p>画像なし</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="image">設備画像を変更する</label>
                    <input type="file"
                           name="image"
                           id="image"
                           class="form-control-file">
                </div>

                <div class="form-group">
                    <label for="name">設備名</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           value="{{ old('name', $equipment->name) }}">
                </div>

                <div class="form-group">
                    <label for="category_id">カテゴリ</label>
                    <select name="category_id"
                            id="category_id"
                            class="form-control">

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @php
                    $startHour = old(
                        'start_hour',
                        \Carbon\Carbon::parse($equipment->available_time_start)->format('H')
                    );

                    $startMinute = old(
                        'start_minute',
                        \Carbon\Carbon::parse($equipment->available_time_start)->format('i')
                    );
                @endphp

                <div class="form-group">
                    <label>利用開始時間</label>

                    <div class="form-row">
                        <div class="col">
                            <select name="start_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    @php
                                        $hourValue = sprintf('%02d', $hour);
                                    @endphp

                                    <option value="{{ $hourValue }}"
                                        {{ $startHour == $hourValue ? 'selected' : '' }}>
                                        {{ $hourValue }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            時
                        </div>

                        <div class="col">
                            <select name="start_minute" class="form-control">
                                <option value="00" {{ $startMinute == '00' ? 'selected' : '' }}>00</option>
                                <option value="30" {{ $startMinute == '30' ? 'selected' : '' }}>30</option>
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            分
                        </div>
                    </div>
                </div>

                @php
                    $endHour = old(
                        'end_hour',
                        \Carbon\Carbon::parse($equipment->available_time_end)->format('H')
                    );

                    $endMinute = old(
                        'end_minute',
                        \Carbon\Carbon::parse($equipment->available_time_end)->format('i')
                    );
                @endphp

                <div class="form-group">
                    <label>利用終了時間</label>

                    <div class="form-row">
                        <div class="col">
                            <select name="end_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    @php
                                        $hourValue = sprintf('%02d', $hour);
                                    @endphp

                                    <option value="{{ $hourValue }}"
                                        {{ $endHour == $hourValue ? 'selected' : '' }}>
                                        {{ $hourValue }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            時
                        </div>

                        <div class="col">
                            <select name="end_minute" class="form-control">
                                <option value="00" {{ $endMinute == '00' ? 'selected' : '' }}>00</option>
                                <option value="30" {{ $endMinute == '30' ? 'selected' : '' }}>30</option>
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            分
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">説明</label>
                    <textarea name="description"
                              id="description"
                              class="form-control"
                              rows="4">{{ old('description', $equipment->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    更新する
                </button>

                <a href="{{ route('admin.equipments') }}"
                   class="btn btn-secondary">
                    設備一覧へ戻る
                </a>
            </form>
        </div>
    </div>
</div>
@endsection