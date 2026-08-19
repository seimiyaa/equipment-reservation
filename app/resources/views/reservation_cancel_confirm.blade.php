<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約キャンセル確認</title>
</head>
<body>
    <h1>予約キャンセル確認</h1>

    <p>設備名：{{ $reservation->equipment->name }}</p>
    <p>利用開始日時：{{ $reservation->start_datetime }}</p>
    <p>利用終了日時：{{ $reservation->end_datetime }}</p>

    <p>この予約をキャンセルしますか？</p>

    <form action="{{ route('reservation.cancel', $reservation->id) }}" method="POST">
        @csrf
        <button type="submit">キャンセルする</button>
    </form>

    <a href="{{ route('reservation.detail', $reservation->id) }}">予約詳細へ戻る</a>
</body>
</html>