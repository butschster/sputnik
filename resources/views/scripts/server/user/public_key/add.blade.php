
echo "{!! $key->key !!}" > {{ $user->homeDir() }}/.ssh/authorized_keys.d/{{ $key->id }}.pub
cat {{ $user->homeDir() }}/.ssh/authorized_keys.d/* > {{ $user->homeDir() }}/.ssh/authorized_keys
