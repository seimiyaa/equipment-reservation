@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー登録</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">ユーザー名</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control"
                           value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="role">権限</label>
                    <select name="role"
                            id="role"
                            class="form-control">

                        <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>
                            一般ユーザー
                        </option>

                        <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>
                            管理者
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    登録する
                </button>

                <a href="{{ route('admin.users') }}"
                   class="btn btn-secondary">
                    ユーザー一覧へ戻る
                </a>
            </form>
        </div>
    </div>
</div>
@endsection