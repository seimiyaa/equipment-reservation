<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者トップ</title>
</head>
<body>
    <h1>管理者トップ</h1>

    <ul>
        <li><a href="{{ route('admin.reservations') }}">予約・履歴一覧</a></li>
        <li><a href="{{ route('admin.equipments') }}">設備管理</a></li>
        <li><a href="{{ route('admin.users') }}">ユーザー管理</a></li>
        <li><a href="{{ route('admin.user.report') }}">ユーザー利用状況レポート</a></li>
    </ul>
</body>
</html>
