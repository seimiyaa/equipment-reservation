
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    パスワード再設定
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('password.reset.send') }}"
                          method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="email">
                                メールアドレス
                            </label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   value="{{ old('email') }}">
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            送信
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