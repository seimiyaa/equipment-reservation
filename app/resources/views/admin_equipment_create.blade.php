<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>設備登録</title>
</head>
<body>
    <h1>設備登録</h1>

    <form action="{{ route('admin.equipment.store') }}" method="POST">
        @csrf

        <p>
            <label>設備名</label><br>
            <input type="text" name="name">
        </p>

        <p>
            <label>カテゴリ</label><br>
            <select name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>利用開始時間</label><br>
            <input type="time" name="available_time_start">
        </p>

        <p>
            <label>利用終了時間</label><br>
            <input type="time" name="available_time_end">
        </p>

        <p>
            <label>説明</label><br>
            <textarea name="description"></textarea>
        </p>

        <button type="submit">登録する</button>
    </form>

    <a href="{{ route('admin.equipments') }}">設備一覧へ戻る</a>
</body>
</html>