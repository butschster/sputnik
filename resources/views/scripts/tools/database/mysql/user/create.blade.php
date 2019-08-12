@foreach($hosts as $host)
mysql --user="root" --password="{!! $password !!}" -e "CREATE USER '{{ $user }}'@'{{ $host }}' IDENTIFIED BY '{!! $password !!}';"
mysql --user="root" --password="{!! $password !!}" -e "GRANT ALL ON *.* TO {{ $user }}@'{{ $host }}' IDENTIFIED BY '{!! $password !!}';"
@endforeach

mysql --user="root" --password="{!! $password !!}" -e "FLUSH PRIVILEGES;"
