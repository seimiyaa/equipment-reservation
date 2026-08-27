@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約一覧</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>設備名</th>
                    <th>利用開始日時</th>
                    <th>利用終了日時</th>
                    <th>状況</th>
                    <th>詳細</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->equipment->name }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y/m/d H:i') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y/m/d H:i') }}
                        </td>

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
                            <a href="{{ route('reservation.detail', $reservation->id) }}"
                               class="btn btn-sm btn-primary">
                                詳細を見る
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('mypage') }}"
       class="btn btn-secondary">
        マイページへ
    </a>
</div>
@endsection