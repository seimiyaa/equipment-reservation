@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">設備一覧</h1>

    <form method="GET"
        action="{{ route('admin.equipments') }}"
        class="mb-4">

        <div class="form-row">

            <div class="col-md-5">
                <label for="name">設備名</label>
                <input type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ request('name') }}"
                    placeholder="設備名を入力">
            </div>

            <div class="col-md-5">
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

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit"
                        class="btn btn-primary btn-block">
                    検索
                </button>
            </div>

        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('admin.equipment.create') }}"
           class="btn btn-primary">
            設備を登録する
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>設備画像</th>
                    <th>設備名</th>
                    <th>カテゴリ</th>
                    <th>利用開始時間</th>
                    <th>利用終了時間</th>
                    <th>編集</th>
                    <th>削除</th>
                    <th>説明</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($equipments as $equipment)
                    <tr>
                        <td>
                            @if ($equipment->image_path)
                                <img src="{{ asset('storage/' . $equipment->image_path) }}"
                                    alt="{{ $equipment->name }}"
                                    width="120">
                            @else
                                画像なし
                            @endif
                        </td>
                        <td>{{ $equipment->name }}</td>
                        <td>{{ $equipment->category->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($equipment->available_time_start)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($equipment->available_time_end)->format('H:i') }}</td>
                        <td>{{ $equipment->description }}</td>

                        <td>
                            <a href="{{ route('admin.equipment.edit', $equipment->id) }}"
                               class="btn btn-sm btn-primary">
                                編集
                            </a>
                        </td>

                        <td>
                            <a href="{{ route('admin.equipment.delete_confirm', $equipment->id) }}"
                               class="btn btn-sm btn-danger">
                                削除
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.top') }}"
       class="btn btn-secondary">
        管理者トップへ戻る
    </a>
</div>
@endsection