
mysql --user="{{ $user->getName() }}" --password="{!! $user->getPassword() !!}" -e "{{ $slot }};"
