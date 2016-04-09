@loop(range(0, 5) as $val)
{{ $val }}={{ $loop->index }}
@endloop