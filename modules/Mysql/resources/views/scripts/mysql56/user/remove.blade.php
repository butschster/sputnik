@foreach($hosts as $host)
    mysql --user="{!! $user->getName() !!}" --password="{!! $user->getPassword() !!}" -e "DROP USER IF EXISTS '{{ $user->getName() }}'@'{{ $host }}';"
@endforeach