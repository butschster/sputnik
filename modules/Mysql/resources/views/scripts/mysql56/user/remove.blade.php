@foreach($hosts as $host)

@mysql(['user' => $root])
DROP USER IF EXISTS '{{ $user->getName() }}'@'{{ $host }}
@endmysql
@endforeach

@mysql(['user' => $root])
FLUSH PRIVILEGES
@endmysql