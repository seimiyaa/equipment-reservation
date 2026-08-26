@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約詳細</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>ユーザー名：</strong>{{ $reservation->user->name }}</p>
            <p><strong>メールアドレス：</strong>{{ $reservation->user->email }}</p>
            <p><strong>設備名：</strong>{{ $reservation->equipment->name }}</p>
            <p><strong>利用開始日時：</strong>{{ $reservation->start_datetime }}</p>
            <p><strong>利用終了日時：</strong>{{ $reservation->end_datetime }}</p>

            <p>
                <strong>予約状況：</strong>

                @if ($reservation->status == 0)
                    <span class="badge badge-primary">予約中</span>
                @elseif ($reservation->status == 1)
                    <span class="badge badge-secondary">利用済</span>
                @elseif ($reservation->status == 2)
                    <span class="badge badge-danger">キャンセル済</span>
                @endif
            </p>
        </div>
    </div>

    <a href="{{ route('admin.reservations') }}"
       class="btn btn-secondary mt-3">
        予約・履歴一覧へ戻る
    </a>
</div>
@endsection