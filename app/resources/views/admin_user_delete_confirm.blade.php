@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー削除確認</h1>

    <div class="alert alert-warning">
        <p class="mb-1">本当にこのユーザーを削除しますか？</p>
        <small>※削除したユーザーは元に戻せません</small>
    </div>

    <div class="card">
        <div class="card-body">

            <p>
                <strong>ユーザー名：</strong>
                {{ $user->name }}
            </p>

            <p>
                <strong>メールアドレス：</strong>
                {{ $user->email }}
            </p>

            <p>
                <strong>権限：</strong>

                @if ($user->role == 0)
                    管理者
                @else
                    一般ユーザー
                @endif
            </p>

            <form action="{{ route('admin.user.destroy', $user->id) }}"
                  method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    削除する
                </button>

                <a href="{{ route('admin.users') }}"
                   class="btn btn-secondary">
                    ユーザー一覧へ戻る
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