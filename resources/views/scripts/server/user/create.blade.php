
@if(!$user->isRoot())
# ================================================
# Create {{ $user->name }} User
# ================================================

useradd --home {{ $user->homeDir() }} {{ $user->name }}
mkdir -p {{ $user->homeDir() }}/.ssh
mkdir -p {{ $user->homeDir() }}/.sputnik

@if($user->sudo)
adduser {{ $user->name }} sudo
@endif

# Setup Bash For The {{ $user->name }} User

chsh -s /bin/bash {{ $user->name }}
cp /root/.profile {{ $user->homeDir() }}/.profile
cp /root/.bashrc {{ $user->homeDir() }}/.bashrc

# Set The Sudo Password For The {{ $user->name }} User

PASSWORD=$(mkpasswd {!! $user->sudo_password !!})
usermod --password $PASSWORD {{ $user->name }}

# Build SSH Key Directories

mkdir -p {{ $user->homeDir() }}/.ssh/authorized_keys.d

@include('scripts.server.user.add_keypair')
@endif