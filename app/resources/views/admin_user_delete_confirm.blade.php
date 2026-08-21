<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー削除確認</title>
</head>
<body>
    <h1>ユーザー削除確認</h1>

    <p>以下のユーザーを削除しますか？</p>

    <p>ユーザー名：{{ $user->name }}</p>
    <p>メールアドレス：{{ $user->email }}</p>
    <p>
        権限：
        @if ($user->role == 0)
            管理者
        @else
            一般ユーザー
        @endif
    </p>

    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
    @csrf
    @method('DELETE')

        <button type="submit">削除する</button>
    </form>

    <a href="{{ route('admin.users') }}">ユーザー一覧へ戻る</a>
</body>
</html>