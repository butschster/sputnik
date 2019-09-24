@foreach($hosts as $host)
mysql --user="root" --password="{!! $password !!}" -e "DROP USER IF EXISTS '{{ $user->getName() }}'@'{{ $host }}';"
@endforeach