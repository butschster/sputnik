@if(is_array($site->environment))
@foreach($site->environment as $key => $value)
{{ $key }}="{!! $value !!}"
@endforeach
@endif
