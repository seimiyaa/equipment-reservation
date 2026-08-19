<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再設定</title>
</head>
<body>
    <h1>パスワード再設定</h1>

    <form action="{{ route('password.reset.send') }}" method="POST">
        @csrf

        <label>メールアドレス</label>
        <input type="email" name="email">

        <button type="submit">送信</button>
    </form>
</body>
</html>
