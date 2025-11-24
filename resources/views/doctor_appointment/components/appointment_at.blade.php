<div class="badge bg-info">
    <div class="mb-2">
        @php
            $from = \Carbon\Carbon::createFromFormat('h:i A', $row->from_time . ' ' . $row->from_time_type);
            $to = \Carbon\Carbon::createFromFormat('h:i A', $row->to_time . ' ' . $row->to_time_type);
        @endphp
        {{ $from->format('H:i') }} - {{ $to->format('H:i') }}
    </div>
    <div class="">{{ \Carbon\Carbon::parse($row->date)->isoFormat('DD MMM YYYY') }}
    </div>
</div>
