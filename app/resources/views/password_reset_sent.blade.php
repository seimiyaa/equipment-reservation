@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card text-center">
                <div class="card-body">

                    <h1 class="mb-4">
                        パスワード再設定
                    </h1>

                    <p class="mb-4">
                        パスワード再設定用の案内を送信しました。
                    </p>

                    <a href="{{ route('login') }}"
                       class="btn btn-primary">
                        ログイン画面へ戻る
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection