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

                let html = '<h5>' + year + '年' + month + '月</h5>';

                if (data.reservations.length === 0) {
                    html += '<p>この月の予約はありません。</p>';
                } else {
                    html += '<ul class="list-group">';

                    data.reservations.forEach(function(reservation) {
                        const start = new Date(reservation.start_datetime);
                        const end = new Date(reservation.end_datetime);

                        const startText =
                            start.getFullYear() + '/' +
                            String(start.getMonth() + 1).padStart(2, '0') + '/' +
                            String(start.getDate()).padStart(2, '0') + ' ' +
                            String(start.getHours()).padStart(2, '0') + ':' +
                            String(start.getMinutes()).padStart(2, '0');

                        const endText =
                            end.getFullYear() + '/' +
                            String(end.getMonth() + 1).padStart(2, '0') + '/' +
                            String(end.getDate()).padStart(2, '0') + ' ' +
                            String(end.getHours()).padStart(2, '0') + ':' +
                            String(end.getMinutes()).padStart(2, '0');

                        html += '<li class="list-group-item">'
                            + startText
                            + ' ～ '
                            + endText
                            + '</li>';
                    });

                    html += '</ul>';
                }

                calendar.innerHTML = html;
            })
            .catch(() => {
                document.getElementById('reservationCalendar').innerHTML =
                    '<p>予約状況の取得に失敗しました。</p>';
            });
    }

    document.getElementById('prevMonth').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        loadCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        loadCalendar();
    });

    loadCalendar();
</script>

@endsection