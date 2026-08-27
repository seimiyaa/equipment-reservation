@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    新しいパスワード設定
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('password.reset.update') }}"
                          method="POST">
                        @csrf

                        <input type="hidden"
                               name="token"
                               value="{{ $token }}">

                        <div class="form-group">
                            <label for="password">
                                新しいパスワード
                            </label>

                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                新しいパスワード（確認）
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control">
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            パスワードを変更する
                        </button>

                        <a href="{{ route('login') }}"
                           class="btn btn-secondary">
                            ログイン画面へ戻る
                        </a>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection