@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">設備登録</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.equipment.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label for="image">設備画像</label>
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
                           value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="category_id">カテゴリ</label>
                    <select name="category_id"
                            id="category_id"
                            class="form-control">

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>利用開始時間</label>

                    <div class="form-row">
                        <div class="col">
                            <select name="start_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    <option value="{{ sprintf('%02d', $hour) }}">
                                        {{ sprintf('%02d', $hour) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            時
                        </div>

                        <div class="col">
                            <select name="start_minute" class="form-control">
                                <option value="00">00</option>
                                <option value="30">30</option>
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            分
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>利用終了時間</label>

                    <div class="form-row">
                        <div class="col">
                            <select name="end_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    <option value="{{ sprintf('%02d', $hour) }}">
                                        {{ sprintf('%02d', $hour) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            時
                        </div>

                        <div class="col">
                            <select name="end_minute" class="form-control">
                                <option value="00">00</option>
                                <option value="30">30</option>
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
                              rows="4">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    登録する
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