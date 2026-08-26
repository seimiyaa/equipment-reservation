@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー一覧</h1>

    <div class="mb-3">
        <a href="{{ route('admin.user.create') }}"
           class="btn btn-primary">
            ユーザー登録
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>予約回数</th>
                    <th>直近利用日</th>
                    <th>権限</th>
                    <th>削除</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td class="text-right">
                            {{ $user->reservations_count ?? 0 }}回
                        </td>

                        <td>
                            @if ($user->reservations->first())
                                {{ \Carbon\Carbon::parse(
                                    $user->reservations->first()->start_datetime
                                )->format('Y/m/d') }}
                            @else
                                利用なし
                            @endif
                        </td>

                        <td>
                            @if ($user->role == 0)
                                管理者
                            @else
                                一般ユーザー
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.user.delete_confirm', $user->id) }}"
                               class="btn btn-sm btn-danger">
                                削除
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.top') }}"
       class="btn btn-secondary">
        管理者トップへ戻る
    </a>
</div>
@endsection