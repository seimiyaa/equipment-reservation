@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">設備削除確認</h1>

    <div class="alert alert-warning">
    <strong>本当にこの設備を削除しますか？</strong><br>
    <small>※削除した設備は元に戻せません</small>
    </div>

    <div class="card">
        <div class="card-body">

            @if ($equipment->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $equipment->image_path) }}"
                         alt="{{ $equipment->name }}"
                         width="200">
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
                <strong>利用可能時間：</strong>
                {{ \Carbon\Carbon::parse($equipment->available_time_start)->format('H:i') }}
                ～
                {{ \Carbon\Carbon::parse($equipment->available_time_end)->format('H:i') }}
            </p>

            <form action="{{ route('admin.equipment.destroy', $equipment->id) }}"
                  method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    削除する
                </button>

                <a href="{{ route('admin.equipments') }}"
                   class="btn btn-secondary">
                    設備一覧へ戻る
                </a>

                <a href="{{ route('admin.top') }}"
                   class="btn btn-outline-secondary">
                    管理者トップへ
                </a>
            </form>
        </div>
    </div>
</div>
@endsection