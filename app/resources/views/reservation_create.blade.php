@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">予約入力</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

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
                <strong>説明：</strong>
                {{ $equipment->description }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('reservation.confirm') }}" method="POST">
                @csrf

                <input type="hidden"
                       name="equipment_id"
                       value="{{ $equipment->id }}">

                <div class="form-group">
                    <label>利用開始日時</label>

                    <div class="form-row">
                        <div class="col-md-5">
                            <input type="date"
                                name="start_date"
                                class="form-control"
                                value="{{ old('start_date') }}">
                        </div>

                        <div class="col">
                            <select name="start_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    <option value="{{ sprintf('%02d', $hour) }}">
                                        {{ sprintf('%02d', $hour) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">時</div>

                        <div class="col">
                            <select name="start_minute" class="form-control">
                                <option value="00">00</option>
                                <option value="30">30</option>
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">分</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>利用終了日時</label>

                    <div class="form-row">
                        <div class="col-md-5">
                            <input type="date"
                                name="end_date"
                                class="form-control"
                                value="{{ old('end_date') }}">
                        </div>

                        <div class="col">
                            <select name="end_hour" class="form-control">
                                @for ($hour = 0; $hour < 24; $hour++)
                                    <option value="{{ sprintf('%02d', $hour) }}">
                                        {{ sprintf('%02d', $hour) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">時</div>

                        <div class="col">
                            <select name="end_minute" class="form-control">
                                <option value="00">00</option>
                                <option value="30">30</option>
                            </select>
                        </div>

                        <div class="col-auto d-flex align-items-center">分</div>
                    </div>
                </div>

                <button type="button"
                        id="checkAvailability"
                        class="btn btn-outline-primary mb-2">
                    空き状況を確認
                </button>

                <p id="availabilityResult"></p>

                <button type="submit"
                        class="btn btn-primary">
                    予約内容確認
                </button>

                <a href="{{ route('equipment.detail', $equipment->id) }}"
                   class="btn btn-secondary">
                    設備詳細画面へ戻る
                </a>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('checkAvailability').addEventListener('click', function () {
    const equipmentId =
        document.querySelector('input[name="equipment_id"]').value;

    const startDate =
        document.querySelector('input[name="start_date"]').value;

    const startHour =
        document.querySelector('select[name="start_hour"]').value;

    const startMinute =
        document.querySelector('select[name="start_minute"]').value;

    const endDate =
        document.querySelector('input[name="end_date"]').value;

    const endHour =
        document.querySelector('select[name="end_hour"]').value;

    const endMinute =
        document.querySelector('select[name="end_minute"]').value;

    const result =
        document.getElementById('availabilityResult');

    if (!startDate || !endDate) {
        result.textContent = '開始日と終了日を入力してください。';
        result.className = 'text-danger mt-2';
        return;
    }

    const startDatetime =
        startDate + ' ' + startHour + ':' + startMinute;

    const endDatetime =
        endDate + ' ' + endHour + ':' + endMinute;

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

        if (data.available) {
            result.className = 'text-success mt-2';
        } else {
            result.className = 'text-danger mt-2';
        }
    })
    .catch(() => {
        result.textContent = '空き状況の確認に失敗しました。';
        result.className = 'text-danger mt-2';
    });
});
</script>
@endsection