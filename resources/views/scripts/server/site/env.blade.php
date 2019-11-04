@if(is_array($environment))
@foreach($environment as $key => $value)
{{ $key }}="{!! $value !!}"
@endforeach
@endif
