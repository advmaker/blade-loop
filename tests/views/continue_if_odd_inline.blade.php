@loop(range(0, 5) as $val)@continue($loop->odd){{ $val }}={{ $loop->index }};@endloop
