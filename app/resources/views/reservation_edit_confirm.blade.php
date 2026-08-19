<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約変更確認</title>
</head>
<body>
    <h1>予約変更確認</h1>

    <p>設備名：{{ $reservation->equipment->name }}</p>
    <p>変更後の利用開始日時：{{ $start_datetime }}</p>
    <p>変更後の利用終了日時：{{ $end_datetime }}</p>

    <form action="{{ route('reservation.update', $reservation->id) }}" method="POST">
    @csrf
    @method('PUT')

        <input type="hidden" name="start_datetime" value="{{ $start_datetime }}">
        <input type="hidden" name="end_datetime" value="{{ $end_datetime }}">

        <button type="submit">変更する</button>
    </form>

    <a href="{{ route('reservation.edit', $reservation->id) }}">編集画面に戻る</a>
</body>
</html>