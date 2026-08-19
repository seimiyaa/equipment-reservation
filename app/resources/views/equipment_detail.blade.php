<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>設備詳細</title>
</head>
<body>
    <h1>設備詳細</h1>

    <p>設備名：{{ $equipment->name }}</p>
    <p>利用可能開始時間：{{ $equipment->available_time_start }}</p>
    <p>利用可能終了時間：{{ $equipment->available_time_end }}</p>
    <p>説明：{{ $equipment->description }}</p>

    <a href="{{ route('reservation.create', ['equipment_id' => $equipment->id]) }}">
    この設備を予約する
    </a>

    <a href="{{ route('equipment.list') }}">設備一覧へ戻る</a>
</body>
</html>