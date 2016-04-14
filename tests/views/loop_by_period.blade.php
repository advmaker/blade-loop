@loop($period as $date)
{{ $loop->index1 }}: {{ $date->format('Y-m-d') }}
@endloop
