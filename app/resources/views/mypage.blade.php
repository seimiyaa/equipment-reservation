<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
</head>
<body>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
    <h1>マイページ</h1>

    <p>マイページです。</p>

    <h2>今後の利用予定</h2>

    @foreach ($upcomingReservations as $reservation)
        <div>
            <p>設備名：{{ $reservation->equipment->name }}</p>
            <p>開始：{{ $reservation->start_datetime }}</p>
            <p>終了：{{ $reservation->end_datetime }}</p>
            <a href="{{ route('reservation.detail', $reservation->id) }}">詳細を見る</a>
            <hr>
        </div>
    @endforeach

    <h2>過去の利用履歴</h2>

    @foreach ($pastReservations as $reservation)
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