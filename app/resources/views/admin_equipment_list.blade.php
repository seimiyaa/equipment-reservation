<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>設備一覧</title>
</head>
<body>
    <h1>設備一覧</h1>

    <table border="1">
        <tr>
            <th>設備名</th>
            <th>カテゴリ</th>
            <th>利用開始時間</th>
            <th>利用終了時間</th>
            <th>編集</th>
            <th>削除</th>
        </tr>

        @foreach ($equipments as $equipment)
            <tr>
                <td>{{ $equipment->name }}</td>
                <td>{{ $equipment->category->name }}</td>
                <td>{{ $equipment->available_time_start }}</td>
                <td>{{ $equipment->available_time_end }}</td>
                <td>
                <a href="{{ route('admin.equipment.edit', $equipment->id) }}">
                    編集
                </a>
                <td>
                    <a href="{{ route('admin.equipment.delete_confirm', $equipment->id) }}">
                        削除
                    </a>
                </td>
                </td>
            </tr>
        @endforeach
    </table>

   

    <a href="{{ route('admin.top') }}">管理者トップへ戻る</a>
</body>
</html>