@loop($arr as $val)@continue(!$loop->first && !$loop->last){{ $val }};@endloop