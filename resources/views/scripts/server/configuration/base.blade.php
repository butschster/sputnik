
export DEBIAN_FRONTEND=noninteractive

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
fail2ban \
software-properties-common \
whois \
unzip

@include('scripts.server.configuration.ssh')

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

@include('scripts.server.configuration.supervisor')

@include('scripts.server.configuration.firewall', ['ports' => [$server->ssh_port]])

@include('scripts.server.configuration.swap')

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
@include('scripts.tools.chown')
@endforeach

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'base.installed'], 10) !!}
