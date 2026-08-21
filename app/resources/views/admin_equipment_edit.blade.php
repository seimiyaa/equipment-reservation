<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>設備編集</title>
</head>
<body>
    <h1>設備編集</h1>

    <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST">
    @csrf
    @method('PUT')

        <p>
            <label>設備名</label><br>
            <input type="text" name="name" value="{{ $equipment->name }}">
        </p>

        <p>
            <label>カテゴリ</label><br>
            <select name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $equipment->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>利用開始時間</label><br>
            <input type="time" name="available_time_start"
                value="{{ $equipment->available_time_start }}">
        </p>

        <p>
            <label>利用終了時間</label><br>
            <input type="time" name="available_time_end"
                value="{{ $equipment->available_time_end }}">
        </p>

        <p>
            <label>説明</label><br>
            <textarea name="description">{{ $equipment->description }}</textarea>
        </p>

        <button type="submit">更新する</button>
    </form>

    <a href="{{ route('admin.equipments') }}">設備一覧へ戻る</a>
</body>
</html>