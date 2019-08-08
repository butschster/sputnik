
# ================================================
# Setup {{ $user }} User
# ================================================

useradd {{ $user }}
mkdir -p /home/{{ $user }}/.ssh
mkdir -p /home/{{ $user }}/.sputnik
adduser {{ $user }} sudo

# Setup Bash For The {{ $user }} User

chsh -s /bin/bash {{ $user }}
cp /root/.profile /home/{{ $user }}/.profile
cp /root/.bashrc /home/{{ $user }}/.bashrc

# Set The Sudo Password For The {{ $user }} User

PASSWORD=$(mkpasswd {!! $server->sudo_password !!})
usermod --password $PASSWORD {{ $user }}

# Build SSH Key Directories

mkdir -p /home/{{ $user }}/.ssh/authorized_keys.d

# Generate Authorized Keys File

echo "{!! $server->public_key !!}" > /home/{{ $user }}/.ssh/authorized_keys.d/server.pub
cat /home/{{ $user }}/.ssh/authorized_keys.d/* > /home/{{ $user }}/.ssh/authorized_keys

# Create The Server SSH Key

ssh-keygen -f /home/{{ $user }}/.ssh/id_rsa -t rsa -N ''

