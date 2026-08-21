<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>設備削除確認</title>
</head>
<body>
    <h1>設備削除確認</h1>

    <p>以下の設備を削除しますか？</p>

    <p>設備名：{{ $equipment->name }}</p>
    <p>カテゴリ：{{ $equipment->category->name }}</p>

    <form action="{{ route('admin.equipment.destroy', $equipment->id) }}" method="POST">
    @csrf
    @method('DELETE')

        <button type="submit">削除する</button>
    </form>

    <a href="{{ route('admin.equipments') }}">設備一覧へ戻る</a>
</body>
</html>