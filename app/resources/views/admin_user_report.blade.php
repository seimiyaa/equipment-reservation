@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー利用状況レポート</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ユーザー名</th>
                    <th class="text-right">予約回数</th>
                    <th>直近利用日</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>

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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.top') }}"
       class="btn btn-secondary">
        管理者トップへ戻る
    </a>

    <a href="{{ route('admin.users') }}"
       class="btn btn-outline-secondary">
        ユーザー一覧へ
    </a>
</div>
@endsection