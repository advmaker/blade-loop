@loop($arr as $i)
{{ $i }}={{ $loop->index }}
@loop($arr_inner as $j)
{{ $i }}{{$j}}={{ $loop->parent->index }}{{ $loop->index1 }}
@endloop
{{ $i }}={{ $loop->index1 }}
@endloop