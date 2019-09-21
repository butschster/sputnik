
export DEBIAN_FRONTEND=noninteractive

# Run Base Script

# Wait For Apt To Unlock

while fuser /var/lib/dpkg/lock >/dev/null 2>&1 ; do
echo "Waiting for other software managers to finish..."

sleep 1
done

# Update & Install Packages

apt-get update
apt-get upgrade -y

apt-get install -y --force-yes build-essential \
fail2ban \
ufw \
software-properties-common \
openvpn \
ca-certificates

@include('scripts.server.configuration.partials.ssh')
{!! callback_event($server->id, 'ssh.configured', 10) !!}

# Set The Timezone

ln -sf /usr/share/zoneinfo/UTC /etc/localtime

# Create The Root SSH Directory If Necessary

echo "{!! $server->private_key !!}" > /root/.ssh/id_rsa
chmod 600 /root/.ssh/id_rsa

@include('scripts.server.configuration.partials.firewall', ['ports' => [$server->ssh_port]])
{!! callback_event($server->id, 'firewall.configured', 40) !!}

{!! callback_event($server->id, 'base.installed', 60) !!}

@include('scripts.server.openvpn.install')

{!! callback_event($server->id, 'openvpn.installed', 80) !!}

{!! callback_event($server->id, 'server.configured', 100) !!}