
# Set The Proper Directory Permissions

chown -R {{ $user }}:{{ $user }} /home/{{ $user }}
chmod -R 755 /home/{{ $user }}

chmod 700 /home/{{ $user }}/.ssh
chmod 700 /home/{{ $user }}/.ssh/authorized_keys.d

chmod 644 /home/{{ $user }}/.ssh/authorized_keys.d/*
chmod 644 /home/{{ $user }}/.ssh/authorized_keys
chmod 644 /home/{{ $user }}/.ssh/id_rsa.pub
chmod 600 /home/{{ $user }}/.ssh/id_rsa
