
@php
$configurator = server_configurator($server);
$users = $configurator->systemUsers();
@endphp

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
curl \
ufw \
fail2ban \
software-properties-common \
whois \
unzip

@include('scripts.server.configuration.partials.ssh')
{!! callback_event($server->id, 'ssh.configured', 10) !!}

# Set The Hostname

echo "{!! $server->name !!}" > /etc/hostname
sed -i 's/127\.0\.0\.1.*localhost/127.0.0.1 {!!$server->name !!} localhost/' /etc/hosts
hostname {!! $server->name !!}

# Set The Timezone

ln -sf /usr/share/zoneinfo/UTC /etc/localtime

# Create The Root SSH Directory If Necessary

echo "{!! $server->private_key !!}" > /root/.ssh/id_rsa
chmod 600 /root/.ssh/id_rsa

@foreach($users as $user)
    @include('scripts.server.user.create')
@endforeach
{!! callback_event($server->id, 'users.created', 20) !!}

@include('scripts.server.configuration.partials.supervisor')
{!! callback_event($server->id, 'supervisor.installed', 30) !!}

@include('scripts.server.configuration.partials.firewall', ['ports' => [$server->ssh_port]])
{!! callback_event($server->id, 'firewall.configured', 40) !!}

@include('scripts.server.configuration.partials.swap')
{!! callback_event($server->id, 'swap.created', 50) !!}

# Setup Unattended Security Upgrades

cat > /etc/apt/apt.conf.d/50unattended-upgrades << EOF
Unattended-Upgrade::Allowed-Origins {
"Ubuntu zesty-security";
};

Unattended-Upgrade::Package-Blacklist {
//
};
EOF

cat > /etc/apt/apt.conf.d/10periodic << EOF
APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Download-Upgradeable-Packages "1";
APT::Periodic::AutocleanInterval "7";
APT::Periodic::Unattended-Upgrade "1";
EOF

# Make Sure Directories Have Correct Permissions
@foreach($users as $user)
    @include('scripts.utils.chown')
@endforeach

{!! callback_event($server->id, 'base.installed', 60) !!}

# Run PHP Installation Script
{!! $configurator->php()->install() !!}

# Run Webserver Installation Script
{!! $configurator->webserver()->install() !!}


# Run Database Installation Script
{!! $configurator->database()->install() !!}

{{--
# Run Node Installation Script

@include('scripts.tools.node.install')
--}}

# Run Redis Installation Script

@include('scripts.tools.redis.install')

{!! callback_event($server->id, 'server.configured', 100) !!}