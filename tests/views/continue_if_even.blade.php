@loop(range(0, 5) as $val)
@continue($loop->even)
{{ $val }}={{ $loop->index }}
@endloop