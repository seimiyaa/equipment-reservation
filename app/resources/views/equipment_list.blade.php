<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>設備一覧</title>
</head>
<body>
    <h1>設備一覧</h1>

    @foreach ($equipments as $equipment)
        <div>
            <p>
                <a href="{{ route('equipment.detail', $equipment->id) }}">
                    {{ $equipment->name }}
                </a>
            </p>
        </div>
    @endforeach
</body>
</html>