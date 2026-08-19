<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約確認</title>
</head>
<body>
    <h1>予約確認</h1>

    <p>設備名：{{ $equipment->name }}</p>
    <p>利用開始日時：{{ $start_datetime }}</p>
    <p>利用終了日時：{{ $end_datetime }}</p>

    <form action="{{ route('reservation.store') }}" method="POST">
        @csrf

        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
        <input type="hidden" name="start_datetime" value="{{ $start_datetime }}">
        <input type="hidden" name="end_datetime" value="{{ $end_datetime }}">

        <button type="submit">予約する</button>
    </form>

    <a href="{{ route('reservation.create', $equipment->id) }}">入力画面に戻る</a>
</body>
</html>