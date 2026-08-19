<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約一覧</title>
</head>
<body>
    <h1>予約一覧</h1>

    @foreach ($reservations as $reservation)
        <div>
            <p>設備名：{{ $reservation->equipment->name }}</p>
            <p>開始：{{ $reservation->start_datetime }}</p>
            <p>終了：{{ $reservation->end_datetime }}</p>
            <a href="{{ route('reservation.detail', $reservation->id) }}">詳細を見る</a>
            <hr>
        </div>
    @endforeach
</body>
</html>