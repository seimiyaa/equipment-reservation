<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約入力</title>
</head>
<body>
    <h1>予約入力</h1>

    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <p>設備名：{{ $equipment->name }}</p>

    <form action="{{ route('reservation.confirm') }}" method="POST">
        @csrf

        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

        <div>
            <label for="start_datetime">利用開始日時</label>
            <input type="datetime-local" name="start_datetime" id="start_datetime">
        </div>

        <div>
            <label for="end_datetime">利用終了日時</label>
            <input type="datetime-local" name="end_datetime" id="end_datetime">
        </div>

        <button type="button" id="checkAvailability">空き状況を確認</button>

        <p id="availabilityResult"></p>

        <button type="submit">確認へ</button>
    </form>

    <script>
    document.getElementById('checkAvailability').addEventListener('click', function () {
        const equipmentId = document.querySelector('input[name="equipment_id"]').value;
        const startDatetime = document.getElementById('start_datetime').value;
        const endDatetime = document.getElementById('end_datetime').value;
        const result = document.getElementById('availabilityResult');

        if (!startDatetime || !endDatetime) {
            result.textContent = '開始日時と終了日時を入力してください。';
            return;
        }

        fetch("{{ route('reservation.check_availability') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                equipment_id: equipmentId,
                start_datetime: startDatetime,
                end_datetime: endDatetime
            })
        })
        .then(response => response.json())
        .then(data => {
            result.textContent = data.message;
        })
        .catch(error => {
            result.textContent = '空き状況の確認に失敗しました。';
        });
    });
</script>

</body>
</html>