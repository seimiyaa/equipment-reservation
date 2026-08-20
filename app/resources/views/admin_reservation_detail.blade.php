<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約詳細</title>
</head>
<body>
    <h1>予約詳細</h1>

    <p>ユーザー名：{{ $reservation->user->name }}</p>
    <p>メールアドレス：{{ $reservation->user->email }}</p>
    <p>設備名：{{ $reservation->equipment->name }}</p>
    <p>利用開始日時：{{ $reservation->start_datetime }}</p>
    <p>利用終了日時：{{ $reservation->end_datetime }}</p>

    <p>
        予約状況：
        @if ($reservation->status == 0)
            予約中
        @elseif ($reservation->status == 1)
            利用済
        @elseif ($reservation->status == 2)
            キャンセル済
        @endif
    </p>

    <a href="{{ route('admin.reservations') }}">予約・履歴一覧へ戻る</a>
</body>
</html>