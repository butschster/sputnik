
export DEBIAN_FRONTEND=noninteractive

# ================================================
# Wait For Apt To Unlock
# ================================================
while fuser /var/lib/dpkg/lock >/dev/null 2>&1 ; do
echo "Waiting for other software managers to finish..."

sleep 1
done

# ================================================
# Update & Install Packages
# ================================================
apt-get update
apt-get upgrade -y

apt-get install -y --force-yes build-essential \
curl \
software-properties-common

@include('scripts.server.configuration.partials.ssh')
{!! callback_event($server->id, 'ssh.configured', 10) !!}

# ================================================
# Create The Root SSH Directory If Necessary
# ================================================
echo "{!! $server->private_key !!}" > /root/.ssh/id_rsa
chmod 600 /root/.ssh/id_rsa

@foreach($users as $user)
@include('scripts.server.user.create')
@endforeach

{!! callback_event($server->id, 'users.created', 40) !!}

@foreach($users as $user)
@include('scripts.utils.chown')
@endforeach

ufw allow {{ $server->ssh_port }}

{!! callback_event($server->id, 'server.configured', 100) !!}