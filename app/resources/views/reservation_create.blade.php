<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約入力</title>
</head>
<body>
    <h1>予約入力</h1>

    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <p>設備名：{{ $equipment->name }}</p>

    <form action="{{ route('reservation.confirm') }}" method="POST">
        @csrf

        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

        <div>
            <label for="start_datetime">利用開始日時</label>
            <input type="datetime-local" name="start_datetime" id="start_datetime">
        </div>

        <div>
            <label for="end_datetime">利用終了日時</label>
            <input type="datetime-local" name="end_datetime" id="end_datetime">
        </div>

        <button type="submit">確認へ</button>
    </form>
</body>
</html>