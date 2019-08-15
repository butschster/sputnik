
@if(!$user->isRoot())
# Set The Proper Directory Permissions

chown -R {{ $user->name }}:{{ $user->name }} {{ $user->homeDir() }}
chmod -R 755 {{ $user->homeDir() }}

chmod 700 {{ $user->homeDir() }}/.ssh
chmod 700 {{ $user->homeDir() }}/.ssh/authorized_keys.d

chmod 644 {{ $user->homeDir() }}/.ssh/authorized_keys.d/*
chmod 644 {{ $user->homeDir() }}/.ssh/authorized_keys
chmod 644 {{ $user->homeDir() }}/.ssh/id_rsa.pub
chmod 600 {{ $user->homeDir() }}/.ssh/id_rsa
@endif
