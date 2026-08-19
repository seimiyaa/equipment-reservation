<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約編集</title>
</head>
<body>
    <h1>予約編集</h1>

    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <p>設備名：{{ $reservation->equipment->name }}</p>

    <form action="{{ route('reservation.edit_confirm', $reservation->id) }}" method="POST">
        @csrf

        <div>
            <label for="start_datetime">利用開始日時</label>
            <input
                type="datetime-local"
                name="start_datetime"
                id="start_datetime"
                value="{{ date('Y-m-d\TH:i', strtotime($reservation->start_datetime)) }}"
            >
        </div>

        <div>
            <label for="end_datetime">利用終了日時</label>
            <input
                type="datetime-local"
                name="end_datetime"
                id="end_datetime"
                value="{{ date('Y-m-d\TH:i', strtotime($reservation->end_datetime)) }}"
            >
        </div>

        <button type="submit">変更内容を確認する</button>
    </form>

    <a href="{{ route('reservation.detail', $reservation->id) }}">予約詳細へ戻る</a>
</body>
</html>