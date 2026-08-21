<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー一覧</title>
</head>
<body>
    <h1>ユーザー一覧</h1>

    <a href="{{ route('admin.user.create') }}">ユーザー登録</a>

    <table border="1">
        <tr>
            <th>ユーザー名</th>
            <th>メールアドレス</th>
            <th>権限</th>
            <th>削除</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->role == 0)
                        管理者
                    @else
                        一般ユーザー
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.user.delete_confirm', $user->id) }}">
                        削除
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('admin.top') }}">管理者トップへ戻る</a>
</body>
</html>