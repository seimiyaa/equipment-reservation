<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf

        <p>
            <label>ユーザー名</label><br>
            <input type="text" name="name">
        </p>

        <p>
            <label>メールアドレス</label><br>
            <input type="email" name="email">
        </p>

        <p>
            <label>パスワード</label><br>
            <input type="password" name="password">
        </p>

        <p>
            <label>権限</label><br>
            <select name="role">
                <option value="1">一般ユーザー</option>
                <option value="0">管理者</option>
            </select>
        </p>

        <button type="submit">登録する</button>
    </form>

    <a href="{{ route('admin.users') }}">ユーザー一覧へ戻る</a>
</body>
</html>