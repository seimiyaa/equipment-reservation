@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約・履歴一覧</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ユーザー名</th>
                    <th>設備名</th>
                    <th>開始日時</th>
                    <th>終了日時</th>
                    <th>ステータス</th>
                    <th>詳細</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->equipment->name }}</td>
                        <td>{{ $reservation->start_datetime }}</td>
                        <td>{{ $reservation->end_datetime }}</td>

                        <td>
                            @if ($reservation->status == 0)
                                <span class="badge badge-primary">予約中</span>
                            @elseif ($reservation->status == 1)
                                <span class="badge badge-secondary">利用済</span>
                            @elseif ($reservation->status == 2)
                                <span class="badge badge-danger">キャンセル済</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.reservation.detail', $reservation->id) }}"
                               class="btn btn-sm btn-primary">
                                詳細を見る
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.top') }}" class="btn btn-secondary">
        管理者トップへ戻る
    </a>
</div>
@endsection