@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body text-center">

            <h1 class="mb-4">予約が完了しました</h1>

            <p class="mb-4">
                予約を受け付けました。
            </p>

            <a href="{{ route('reservation.list') }}"
               class="btn btn-primary">
                予約一覧へ
            </a>

            <a href="{{ route('mypage') }}"
               class="btn btn-secondary">
                マイページへ
            </a>

        </div>
    </div>
</div>
@endsection