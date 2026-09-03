@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">設備詳細</h1>

    <div class="card mb-4">
        <div class="card-body">

            @if ($equipment->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $equipment->image_path) }}"
                         alt="{{ $equipment->name }}"
                         class="img-fluid"
                         style="max-height: 300px;">
                </div>
            @endif

            <p>
                <strong>設備名：</strong>
                {{ $equipment->name }}
            </p>

            <p>
                <strong>カテゴリ：</strong>
                {{ $equipment->category->name }}
            </p>

            <p>
                <strong>利用可能時間：</strong>
                {{ \Carbon\Carbon::parse($equipment->available_time_start)->format('H:i') }}
                ～
                {{ \Carbon\Carbon::parse($equipment->available_time_end)->format('H:i') }}
            </p>

            <p>
                <strong>説明：</strong>
                {{ $equipment->description }}
            </p>
        </div>
    </div>

    <h2 class="mb-3">予約状況カレンダー</h2>

    <div class="mb-3">
        <button type="button"
                id="prevMonth"
                class="btn btn-outline-secondary">
            前月
        </button>

        <button type="button"
                id="nextMonth"
                class="btn btn-outline-secondary">
            次月
        </button>
    </div>

    <div id="reservationCalendar"
         class="border rounded p-3 mb-4">
        予約状況を読み込みます。
    </div>

    <a href="{{ route('reservation.create', ['equipment_id' => $equipment->id]) }}"
       class="btn btn-primary">
        この設備を予約する
    </a>

    <a href="{{ route('equipment.list') }}"
       class="btn btn-secondary">
        設備一覧へ戻る
    </a>
</div>

<script>
    let currentDate = new Date();

    function loadCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1;

        fetch("{{ route('equipment.calendar', $equipment->id) }}?year=" + year + "&month=" + month)
            .then(response => response.json())
            .then(data => {
                const calendar = document.getElementById('reservationCalendar');

                // 日付ごとに予約時間をまとめる
                const reservationsByDay = {};

                data.reservations.forEach(function(reservation) {
                    const startParts = reservation.start_datetime.split(' ');
                    const endParts = reservation.end_datetime.split(' ');

                    const startDate = startParts[0];
                    const startTime = startParts[1].substring(0, 5);
                    const endTime = endParts[1].substring(0, 5);

                    const day = parseInt(startDate.split('-')[2]);

                    if (!reservationsByDay[day]) {
                        reservationsByDay[day] = [];
                    }

                    reservationsByDay[day].push({
                        start: startTime,
                        end: endTime
                    });
                });

                const firstDay = new Date(year, month - 1, 1);
                const lastDay = new Date(year, month, 0);

                const firstWeekday = firstDay.getDay();
                const daysInMonth = lastDay.getDate();

                let html = '';

                html += '<h5 class="mb-3">'
                    + year + '年' + month + '月'
                    + '</h5>';

                // 凡例
                html += '<div class="mb-3">';
                html += '<span class="mr-3 text-success">○ 空き</span>';
                html += '<span class="text-danger">× 予約あり</span>';
                html += '</div>';

                // カレンダー
                html += '<table class="table table-bordered text-center">';
                html += '<thead>';
                html += '<tr>';
                html += '<th>日</th>';
                html += '<th>月</th>';
                html += '<th>火</th>';
                html += '<th>水</th>';
                html += '<th>木</th>';
                html += '<th>金</th>';
                html += '<th>土</th>';
                html += '</tr>';
                html += '</thead>';

                html += '<tbody>';
                html += '<tr>';

                // 月初までの空欄
                for (let i = 0; i < firstWeekday; i++) {
                    html += '<td></td>';
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const weekday = new Date(
                        year,
                        month - 1,
                        day
                    ).getDay();

                    const reserved = !!reservationsByDay[day];

                    // 過去日判定
                    const cellDate = new Date(
                        year,
                        month - 1,
                        day
                    );

                    const today = new Date();

                    today.setHours(0, 0, 0, 0);
                    cellDate.setHours(0, 0, 0, 0);

                    const isPast = cellDate < today;

                    html += '<td '
                        + 'style="cursor:pointer; vertical-align:middle;" '
                        + 'onclick="showDayReservations('
                        + year + ','
                        + month + ','
                        + day + ','
                        + isPast
                        + ')">';

                    html += '<div><strong>'
                        + day
                        + '</strong></div>';

                    // 状況表示
                    if (isPast) {
                        html += '<div '
                            + 'class="text-muted" '
                            + 'style="font-size:24px;">'
                            + '－'
                            + '</div>';
                    } else if (reserved) {
                        html += '<div '
                            + 'class="text-danger" '
                            + 'style="font-size:24px;">'
                            + '×'
                            + '</div>';
                    } else {
                        html += '<div '
                            + 'class="text-success" '
                            + 'style="font-size:24px;">'
                            + '○'
                            + '</div>';
                    }

                    html += '</td>';

                    // 土曜日で次の行へ
                    if (
                        weekday === 6 &&
                        day !== daysInMonth
                    ) {
                        html += '</tr><tr>';
                    }
                }

                // 月末以降の空欄
                const lastWeekday = lastDay.getDay();

                if (lastWeekday !== 6) {
                    for (
                        let i = lastWeekday + 1;
                        i <= 6;
                        i++
                    ) {
                        html += '<td></td>';
                    }
                }

                html += '</tr>';
                html += '</tbody>';
                html += '</table>';

                // クリックした日の詳細表示場所
                html += '<div '
                    + 'id="dayReservationDetail" '
                    + 'class="mt-4">'
                    + '</div>';

                calendar.innerHTML = html;

                // 別関数から使えるように保持
                window.reservationsByDay = reservationsByDay;
            })
            .catch(() => {
                document.getElementById(
                    'reservationCalendar'
                ).innerHTML =
                    '<p class="text-danger">'
                    + '予約状況の取得に失敗しました。'
                    + '</p>';
            });
    }

    function showDayReservations(
        year,
        month,
        day,
        isPast
    ) {
        const detail =
            document.getElementById(
                'dayReservationDetail'
            );

        // 過去日
        if (isPast) {
            detail.innerHTML =
                '<div class="card">'
                + '<div class="card-body">'
                + '<h5>'
                + month + '月' + day + '日'
                + '</h5>'
                + '<p class="text-muted mb-0">'
                + 'この日は予約できません。'
                + '</p>'
                + '</div>'
                + '</div>';

            return;
        }

        const reservations =
            window.reservationsByDay[day];

        let html = '<div class="card">';
        html += '<div class="card-body">';

        html += '<h5>'
            + month + '月' + day
            + '日の予約状況'
            + '</h5>';

        // 空き
        if (!reservations) {
            html += '<p class="text-success mb-0">'
                + '○ この日は予約がありません。'
                + '</p>';
        } else {
            // 予約あり
            html += '<p class="text-danger">'
                + '× 予約あり'
                + '</p>';

            html += '<ul class="list-group">';

            reservations.forEach(
                function(reservation) {
                    html += '<li '
                        + 'class="list-group-item">'
                        + reservation.start
                        + ' ～ '
                        + reservation.end
                        + '</li>';
                }
            );

            html += '</ul>';
        }

        html += '</div>';
        html += '</div>';

        detail.innerHTML = html;
    }

    // 前月
    document.getElementById(
        'prevMonth'
    ).addEventListener(
        'click',
        function () {
            currentDate.setMonth(
                currentDate.getMonth() - 1
            );

            loadCalendar();
        }
    );

    // 次月
    document.getElementById(
        'nextMonth'
    ).addEventListener(
        'click',
        function () {
            currentDate.setMonth(
                currentDate.getMonth() + 1
            );

            loadCalendar();
        }
    );

    // 初回表示
    loadCalendar();
</script>

@endsection