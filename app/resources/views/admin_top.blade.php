@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">管理者トップ</h1>

    <div class="list-group">
        <a href="{{ route('admin.reservations') }}" class="list-group-item list-group-item-action">
            予約・履歴一覧
        </a>

        <a href="{{ route('admin.equipments') }}" class="list-group-item list-group-item-action">
            設備管理
        </a>

        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
            ユーザー管理
        </a>

        <a href="{{ route('admin.user.report') }}" class="list-group-item list-group-item-action">
            ユーザー利用状況レポート
        </a>
    </div>
</div>
@endsection