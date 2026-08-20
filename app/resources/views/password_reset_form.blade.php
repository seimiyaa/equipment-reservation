<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新しいパスワード設定</title>
</head>
<body>
    <h1>新しいパスワード設定</h1>

    <form action="{{ route('password.reset.update') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <label>新しいパスワード</label>
        <input type="password" name="password">

        <label>新しいパスワード（確認）</label>
        <input type="password" name="password_confirmation">

        <button type="submit">パスワードを変更する</button>
    </form>
</body>
</html>