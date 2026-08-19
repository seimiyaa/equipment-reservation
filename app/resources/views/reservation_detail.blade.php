<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約詳細</title>
</head>
<body>
    <h1>予約詳細</h1>

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

    <a href="{{ route('reservation.edit', $reservation->id) }}">予約を編集する</a>
    <a href="{{ route('reservation.cancel_confirm', $reservation->id) }}">予約をキャンセルする</a>

    <a href="{{ route('reservation.list') }}">予約一覧へ戻る</a>
</body>
</html>