@foreach($hosts as $host)
@foreach($user->getGrants() as $grant)

@mysql(['user' => $root])
GRANT ALL ON {{ $grant }} TO {{ $user->getName() }}@'{{ $host }}' IDENTIFIED BY '{!! $user->getPassword() !!}'
@endmysql

@endforeach

@endforeach

@mysql(['user' => $root])
FLUSH PRIVILEGES
@endmysql
