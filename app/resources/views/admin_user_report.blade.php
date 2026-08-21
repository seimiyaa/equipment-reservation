<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー利用状況レポート</title>
</head>
<body>
    <h1>ユーザー利用状況レポート</h1>

    <table border="1">
        <tr>
            <th>ユーザー名</th>
            <th>メールアドレス</th>
            <th>予約件数</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->reservations_count }}</td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('admin.top') }}">管理者トップへ戻る</a>
</body>
</html>