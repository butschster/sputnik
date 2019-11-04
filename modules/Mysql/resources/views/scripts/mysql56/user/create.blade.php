@foreach($hosts as $host)
@foreach($user->getGrants() as $grant)

@mysql(['user' => $root])
CREATE USER {{ $user->getName() }}@'localhost' IDENTIFIED BY '{!! $user->getPassword() !!}'
@endmysql

@mysql(['user' => $root])
GRANT ALL PRIVILEGES ON {{ $grant }} TO {{ $user->getName() }}@'{{ $host }}'
@endmysql

@endforeach

@endforeach

@mysql(['user' => $root])
FLUSH PRIVILEGES
@endmysql
