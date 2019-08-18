@foreach($hosts as $host)
mysql --user="root" --password="{!! $password !!}" -e "CREATE USER '{{ $user->getName() }}'@'{{ $host }}' IDENTIFIED BY '{!! $user->getPassword() !!}';"

@foreach($user->getGrants() as $grant)
mysql --user="root" --password="{!! $password !!}" -e "GRANT ALL ON {{ $grant }} TO {{ $user->getName() }}@'{{ $host }}' IDENTIFIED BY '{!! $user->getPassword() !!}';"
@endforeach

@endforeach

mysql --user="root" --password="{!! $password !!}" -e "FLUSH PRIVILEGES;"
