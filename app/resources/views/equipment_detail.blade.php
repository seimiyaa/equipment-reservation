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
                id="prevWeek"
                class="btn btn-outline-secondary">
            前週
        </button>

        <button type="button"
                id="nextWeek"
                class="btn btn-outline-secondary">
            次週
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
        const startOfWeek = new Date(currentDate);

        // 月曜日始まり
        const day = startOfWeek.getDay();
        const diff = day === 0 ? -6 : 1 - day;

        startOfWeek.setDate(startOfWeek.getDate() + diff);
        startOfWeek.setHours(0, 0, 0, 0);

        const endOfWeek = new Date(startOfWeek);
        endOfWeek.setDate(endOfWeek.getDate() + 6);

        const year = startOfWeek.getFullYear();
        const month = startOfWeek.getMonth() + 1;

        fetch("{{ route('equipment.calendar', $equipment->id) }}?year=" + year + "&month=" + month)
            .then(response => response.json())
            .then(data => {
                const calendar = document.getElementById('reservationCalendar');

                const reservationsByDate = {};

                data.reservations.forEach(function(reservation) {
                    const startParts = reservation.start_datetime.split(' ');
                    const endParts = reservation.end_datetime.split(' ');

                    const startDate = startParts[0];
                    const startTime = startParts[1].substring(0, 5);
                    const endTime = endParts[1].substring(0, 5);

                    if (!reservationsByDate[startDate]) {
                        reservationsByDate[startDate] = [];
                    }

                    reservationsByDate[startDate].push({
                        start: startTime,
                        end: endTime
                    });
                });

                let html = '';

                html += '<h5 class="mb-3">'
                    + (startOfWeek.getMonth() + 1) + '月'
                    + startOfWeek.getDate() + '日 ～ '
                    + (endOfWeek.getMonth() + 1) + '月'
                    + endOfWeek.getDate() + '日'
                    + '</h5>';

                html += '<div class="mb-3">';
                html += '<span class="mr-3 text-success">○ 空き</span>';
                html += '<span class="text-danger">× 予約あり</span>';
                html += '</div>';

                html += '<table class="table table-bordered text-center">';
                html += '<thead><tr>';

                const weekdays = ['月', '火', '水', '木', '金', '土', '日'];

                weekdays.forEach(function(weekday) {
                    html += '<th>' + weekday + '</th>';
                });

                html += '</tr></thead>';
                html += '<tbody><tr>';

                for (let i = 0; i < 7; i++) {
                    const date = new Date(startOfWeek);
                    date.setDate(startOfWeek.getDate() + i);

                    const dateYear = date.getFullYear();
                    const dateMonth = date.getMonth() + 1;
                    const dateDay = date.getDate();

                    const monthText = String(dateMonth).padStart(2, '0');
                    const dayText = String(dateDay).padStart(2, '0');

                    const dateKey =
                        dateYear + '-' +
                        monthText + '-' +
                        dayText;

                    const reservations = reservationsByDate[dateKey];

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const cellDate = new Date(date);
                    cellDate.setHours(0, 0, 0, 0);

                    const isPast = cellDate < today;

                    html += '<td style="vertical-align:middle;">';

                    html += '<div><strong>'
                        + dateMonth + '/' + dateDay
                        + '</strong></div>';

                    if (isPast) {
                        html += '<div class="text-muted" style="font-size:24px;">－</div>';
                    } else if (reservations && reservations.length > 0) {
                        html += '<div class="text-danger" style="font-size:24px;">×</div>';

                        reservations.forEach(function(reservation) {
                            html += '<div class="small">'
                                + reservation.start
                                + ' ～ '
                                + reservation.end
                                + '</div>';
                        });
                    } else {
                        html += '<div class="text-success" style="font-size:24px;">○</div>';
                    }

                    html += '</td>';
                }

                html += '</tr></tbody>';
                html += '</table>';

                calendar.innerHTML = html;
            })
            .catch(() => {
                document.getElementById('reservationCalendar').innerHTML =
                    '<p class="text-danger">'
                    + '予約状況の取得に失敗しました。'
                    + '</p>';
            });
    }

    document.getElementById('prevWeek').addEventListener(
        'click',
        function () {
            currentDate.setDate(
                currentDate.getDate() - 7
            );

            loadCalendar();
        }
    );

    document.getElementById('nextWeek').addEventListener(
        'click',
        function () {
            currentDate.setDate(
                currentDate.getDate() + 7
            );

            loadCalendar();
        }
    );

    loadCalendar();
</script>
@endsection