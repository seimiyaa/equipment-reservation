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


    {{-- 日付をクリックしたら表示 --}}
    <div id="selectedDateArea"
         class="border rounded p-3 mb-4"
         style="display:none;">

        <h5 id="selectedDateTitle"
            class="mb-3">
        </h5>

        <div id="selectedDateReservations"
             class="mb-3">
        </div>

        <a href="#"
           id="selectedDateReservationButton"
           class="btn btn-primary">
            この日を予約する
        </a>

    </div>


    <a href="{{ route(
            'reservation.create',
            ['equipment_id' => $equipment->id]
        ) }}"
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


    const availableStart =
        "{{ \Carbon\Carbon::parse(
            $equipment->available_time_start
        )->format('H:i') }}";


    const availableEnd =
        "{{ \Carbon\Carbon::parse(
            $equipment->available_time_end
        )->format('H:i') }}";


    /*
     * 09:30 → 570分
     */
    function timeToMinutes(time)
    {
        const parts = time.split(':');

        return (
            Number(parts[0]) * 60
            + Number(parts[1])
        );
    }


    /*
     * 現在時刻から、
     * 次に選択できる30分単位の時刻を取得
     *
     * 17:17 → 17:30
     * 17:30 → 17:30
     * 17:31 → 18:00
     */
    function getNextThirtyMinutes()
    {
        const now = new Date();

        let minutes =
            now.getHours() * 60
            + now.getMinutes();


        const remainder =
            minutes % 30;


        if (remainder !== 0) {

            minutes +=
                30 - remainder;

        }


        return minutes;
    }


    /*
     * 指定した日が今日か
     */
    function isToday(date)
    {
        const today = new Date();

        return (
            date.getFullYear()
                === today.getFullYear()
            &&
            date.getMonth()
                === today.getMonth()
            &&
            date.getDate()
                === today.getDate()
        );
    }


    /*
     * 予約可能な30分枠が
     * 1つでも残っているか確認
     */
    function hasAvailableSlot(
        reservations,
        date
    ) {

        const equipmentStart =
            timeToMinutes(
                availableStart
            );


        const equipmentEnd =
            timeToMinutes(
                availableEnd
            );


        /*
         * 基本は設備の利用開始時間から
         */
        let checkStart =
            equipmentStart;


        /*
         * 今日の場合は
         * 現在時刻より前は予約できない
         */
        if (isToday(date)) {

            const nextTime =
                getNextThirtyMinutes();


            checkStart =
                Math.max(
                    equipmentStart,
                    nextTime
                );

        }


        /*
         * もう30分取れない
         */
        if (
            checkStart + 30
            > equipmentEnd
        ) {

            return false;

        }


        /*
         * 30分ずつ確認
         */
        for (
            let slotStart = checkStart;
            slotStart + 30 <= equipmentEnd;
            slotStart += 30
        ) {

            const slotEnd =
                slotStart + 30;


            let overlap = false;


            /*
             * この30分枠と
             * 既存予約が重なるか
             */
            for (
                let i = 0;
                i < reservations.length;
                i++
            ) {

                const reservationStart =
                    timeToMinutes(
                        reservations[i].start
                    );


                const reservationEnd =
                    timeToMinutes(
                        reservations[i].end
                    );


                if (
                    reservationStart < slotEnd
                    &&
                    reservationEnd > slotStart
                ) {

                    overlap = true;

                    break;

                }

            }


            /*
             * 1枠でも空いていれば
             * まだ予約可能
             */
            if (!overlap) {

                return true;

            }

        }


        return false;
    }


    /*
     * カレンダー表示
     */
    function loadCalendar()
    {
        const startOfWeek =
            new Date(currentDate);


        /*
         * 月曜日始まり
         */
        const day =
            startOfWeek.getDay();


        const diff =
            day === 0
                ? -6
                : 1 - day;


        startOfWeek.setDate(
            startOfWeek.getDate()
            + diff
        );


        startOfWeek.setHours(
            0,
            0,
            0,
            0
        );


        /*
         * 日曜日
         */
        const endOfWeek =
            new Date(startOfWeek);


        endOfWeek.setDate(
            endOfWeek.getDate()
            + 6
        );


        const year =
            startOfWeek.getFullYear();


        const month =
            startOfWeek.getMonth()
            + 1;


        /*
         * Ajaxで予約情報取得
         */
        fetch(
            "{{ route(
                'equipment.calendar',
                $equipment->id
            ) }}"
            + "?year="
            + year
            + "&month="
            + month
        )

        .then(response => response.json())

        .then(data => {

            const calendar =
                document.getElementById(
                    'reservationCalendar'
                );


            const reservationsByDate = {};


            /*
             * 日付ごとに予約をまとめる
             */
            data.reservations.forEach(
                function(reservation) {

                    const startParts =
                        reservation
                            .start_datetime
                            .split(' ');


                    const endParts =
                        reservation
                            .end_datetime
                            .split(' ');


                    const startDate =
                        startParts[0];


                    const startTime =
                        startParts[1]
                            .substring(0, 5);


                    const endTime =
                        endParts[1]
                            .substring(0, 5);


                    if (
                        !reservationsByDate[
                            startDate
                        ]
                    ) {

                        reservationsByDate[
                            startDate
                        ] = [];

                    }


                    reservationsByDate[
                        startDate
                    ].push({

                        start: startTime,

                        end: endTime

                    });

                }
            );


            let html = '';


            /*
             * 表示期間
             */
            html +=
                '<h5 class="mb-3">'
                + (startOfWeek.getMonth() + 1)
                + '月'
                + startOfWeek.getDate()
                + '日 ～ '
                + (endOfWeek.getMonth() + 1)
                + '月'
                + endOfWeek.getDate()
                + '日'
                + '</h5>';


            /*
             * 凡例
             */
            html +=
                '<div class="mb-3">';


            html +=
                '<span class="mr-3 text-success">'
                + '○ 空き'
                + '</span>';


            html +=
                '<span class="mr-3" '
                + 'style="color:#d97706;">'
                + '△ 一部予約あり'
                + '</span>';


            html +=
                '<span class="text-danger">'
                + '× 空きなし'
                + '</span>';


            html += '</div>';


            /*
             * カレンダー
             */
            html +=
                '<table '
                + 'class="table table-bordered text-center">';


            html += '<thead><tr>';


            const weekdays =
                [
                    '月',
                    '火',
                    '水',
                    '木',
                    '金',
                    '土',
                    '日'
                ];


            weekdays.forEach(
                function(weekday) {

                    html +=
                        '<th>'
                        + weekday
                        + '</th>';

                }
            );


            html += '</tr></thead>';

            html += '<tbody><tr>';


            /*
             * 7日分
             */
            for (
                let i = 0;
                i < 7;
                i++
            ) {

                const date =
                    new Date(startOfWeek);


                date.setDate(
                    startOfWeek.getDate()
                    + i
                );


                const dateYear =
                    date.getFullYear();


                const dateMonth =
                    date.getMonth()
                    + 1;


                const dateDay =
                    date.getDate();


                const monthText =
                    String(dateMonth)
                        .padStart(2, '0');


                const dayText =
                    String(dateDay)
                        .padStart(2, '0');


                const dateKey =
                    dateYear
                    + '-'
                    + monthText
                    + '-'
                    + dayText;


                const reservations =
                    reservationsByDate[
                        dateKey
                    ] || [];


                /*
                 * 過去判定
                 */
                const today =
                    new Date();


                today.setHours(
                    0,
                    0,
                    0,
                    0
                );


                const cellDate =
                    new Date(date);


                cellDate.setHours(
                    0,
                    0,
                    0,
                    0
                );


                const isPast =
                    cellDate < today;


                /*
                 * 実際に予約可能な
                 * 30分枠が残っているか
                 */
                const available =
                    !isPast
                    && hasAvailableSlot(
                        reservations,
                        date
                    );


                /*
                 * セル
                 */
                html +=
                    '<td '
                    + 'class="calendar-date" '
                    + 'data-date="'
                    + dateKey
                    + '" '
                    + 'data-past="'
                    + (isPast ? '1' : '0')
                    + '" '
                    + 'data-available="'
                    + (available ? '1' : '0')
                    + '" '
                    + 'style="'
                    + 'vertical-align:middle;'
                    + 'cursor:pointer;'
                    + '">';


                /*
                 * 日付
                 */
                html +=
                    '<div><strong>'
                    + dateMonth
                    + '/'
                    + dateDay
                    + '</strong></div>';


                /*
                 * 過去
                 */
                if (isPast) {

                    html +=
                        '<div '
                        + 'class="text-muted" '
                        + 'style="font-size:24px;">'
                        + '－'
                        + '</div>';

                }


                /*
                 * 予約できる時間なし
                 */
                else if (!available) {

                    html +=
                        '<div '
                        + 'class="text-danger" '
                        + 'style="font-size:24px;">'
                        + '×'
                        + '</div>';

                }


                /*
                 * 予約なし
                 */
                else if (
                    reservations.length
                    === 0
                ) {

                    html +=
                        '<div '
                        + 'class="text-success" '
                        + 'style="font-size:24px;">'
                        + '○'
                        + '</div>';

                }


                /*
                 * 一部予約あり
                 */
                else {

                    html +=
                        '<div '
                        + 'style="'
                        + 'font-size:24px;'
                        + 'color:#d97706;'
                        + '">'
                        + '△'
                        + '</div>';

                }


                html += '</td>';

            }


            html += '</tr></tbody>';

            html += '</table>';


            calendar.innerHTML =
                html;


            /*
             * 日付クリック
             */
            const dateCells =
                document.querySelectorAll(
                    '.calendar-date'
                );


            dateCells.forEach(
                function(cell) {

                    cell.addEventListener(
                        'click',
                        function() {

                            const selectedDate =
                                this.dataset.date;


                            const isPast =
                                this.dataset.past
                                === '1';


                            const available =
                                this.dataset.available
                                === '1';


                            const reservations =
                                reservationsByDate[
                                    selectedDate
                                ] || [];


                            showSelectedDate(
                                selectedDate,
                                reservations,
                                isPast,
                                available
                            );

                        }
                    );

                }
            );

        })


        .catch(function(error) {

            console.error(error);


            document.getElementById(
                'reservationCalendar'
            ).innerHTML =

                '<p class="text-danger">'
                + '予約状況の取得に失敗しました。'
                + '</p>';

        });
    }


    /*
     * 選択した日の詳細
     */
    function showSelectedDate(
        selectedDate,
        reservations,
        isPast,
        available
    ) {

        const area =
            document.getElementById(
                'selectedDateArea'
            );


        const title =
            document.getElementById(
                'selectedDateTitle'
            );


        const reservationArea =
            document.getElementById(
                'selectedDateReservations'
            );


        const button =
            document.getElementById(
                'selectedDateReservationButton'
            );


        const parts =
            selectedDate.split('-');


        const month =
            Number(parts[1]);


        const day =
            Number(parts[2]);


        title.textContent =
            month
            + '月'
            + day
            + '日の予約状況';


        /*
         * 予約なし
         */
        if (
            reservations.length
            === 0
        ) {

            reservationArea.innerHTML =

                '<p class="text-success mb-0">'
                + '予約はありません。'
                + '</p>';

        }


        /*
         * 予約あり
         */
        else {

            let html =

                '<p>'
                + '<strong>'
                + '予約済み時間'
                + '</strong>'
                + '</p>';


            html += '<ul>';


            reservations.forEach(
                function(reservation) {

                    html +=
                        '<li>'
                        + reservation.start
                        + ' ～ '
                        + reservation.end
                        + '</li>';

                }
            );


            html += '</ul>';


            reservationArea.innerHTML =
                html;

        }


        /*
         * 過去または空きなしなら
         * 予約ボタンを表示しない
         */
        if (
            isPast
            || !available
        ) {

            button.style.display =
                'none';

        }

        else {

            button.style.display =
                'inline-block';


            button.href =
                "{{ route('reservation.create') }}"
                + "?equipment_id="
                + "{{ $equipment->id }}"
                + "&date="
                + selectedDate;

        }


        area.style.display =
            'block';
    }


    /*
     * 前週
     */
    document
        .getElementById('prevWeek')
        .addEventListener(
            'click',
            function() {

                currentDate.setDate(
                    currentDate.getDate()
                    - 7
                );


                loadCalendar();

            }
        );


    /*
     * 次週
     */
    document
        .getElementById('nextWeek')
        .addEventListener(
            'click',
            function() {

                currentDate.setDate(
                    currentDate.getDate()
                    + 7
                );


                loadCalendar();

            }
        );


    loadCalendar();

</script>

@endsection