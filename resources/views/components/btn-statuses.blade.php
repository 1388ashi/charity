 @php
    $statusColors = [
        'pending' => 'btn-light',
        'new' => 'btn-info',
        'await_payment' => 'btn-warning',
        'paid' => 'btn-success',
        'rejected' => 'btn-danger',
    ];
@endphp

<button class="status-btn btn btn-sm btn-rss">  
    جمع کل ({{  array_sum($totalRows) ?? 0 }})
</button>  
@foreach ($statuses as $statusKey => $statusLabel)  
    <button class="status-btn btn btn-sm {{ $statusColors[$statusKey] }}">  
        {{ $statusLabel }} ({{ $totalRows[$statusKey] ?? 0 }})
    </button>  
@endforeach