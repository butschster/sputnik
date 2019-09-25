
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
software-properties-common \
whois

@include('scripts.server.configuration.partials.ssh')

{!! callback_event($server->id, 'ssh.configured', 10) !!}


@include('scripts.server.configuration.partials.timezone')

{!! callback_event($server->id, 'timezone.configured', 30) !!}

# ================================================
# Create The Root SSH Directory If Necessary
# ================================================
echo "{!! $server->private_key !!}" > /root/.ssh/id_rsa
chmod 600 /root/.ssh/id_rsa

@foreach($users as $user)
@include('scripts.server.user.create')
@endforeach

{!! callback_event($server->id, 'users.created', 40) !!}

@include('scripts.server.configuration.partials.swap')

{!! callback_event($server->id, 'swap.created', 50) !!}


# ================================================
# Setup Unattended Security Upgrades
# ================================================
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

{!! callback_event($server->id, 'updates.configured', 60) !!}

@foreach($users as $user)
@include('scripts.utils.chown')
@endforeach

{!! callback_event($server->id, 'server.configured', 100) !!}