@if ($row->created_at === null)
N/A
@else
    <div class="badge bg-light-primary">
        <div class="mb-2">{{ \Carbon\Carbon::parse($row->created_at)->format('H:i')}}
            <div class="mt-2">
                {{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('jS M, Y')}}
            </div>
        </div>
@endif
