<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約・履歴一覧</title>
</head>
<body>
    <h1>予約・履歴一覧</h1>

    <table border="1">
        <tr>
            <th>ユーザー名</th>
            <th>設備名</th>
            <th>開始日時</th>
            <th>終了日時</th>
            <th>ステータス</th>
            <th>詳細</th>
        </tr>

        @foreach ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->equipment->name }}</td>
                <td>{{ $reservation->start_datetime }}</td>
                <td>{{ $reservation->end_datetime }}</td>
                <td>
                    @if ($reservation->status == 0)
                        予約中
                    @elseif ($reservation->status == 1)
                        利用済
                    @elseif ($reservation->status == 2)
                        キャンセル済
                    @endif
                </td>

                <td>
                    <a href="{{ route('admin.reservation.detail', $reservation->id) }}">
                        詳細を見る
                    </a>
                </td>
                
            </tr>
        @endforeach
    </table>

    <a href="{{ route('admin.top') }}">管理者トップへ戻る</a>
</body>
</html>