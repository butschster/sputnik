
@php
$vars = $configuration->vars();
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
fail2ban \
software-properties-common \
openvpn

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

@include('scripts.server.configuration.partials.firewall', ['ports' => [$server->ssh_port]])
{!! callback_event($server->id, 'firewall.configured', 40) !!}

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

{!! callback_event($server->id, 'base.installed', 60) !!}

wget -P ~/ https://github.com/OpenVPN/easy-rsa/releases/download/v3.0.6/EasyRSA-unix-v3.0.6.tgz
cd ~
tar xvf EasyRSA-unix-v3.0.6.tgz
cd ~/EasyRSA-v3.0.6/
cp vars.example vars

@foreach($vars as $key => $value)
sed -i 's/.*set_var {{ $key }}.*/set_var {{ $key }}="{{ $value }}"/g' vars
@endforeach

./easyrsa init-pki

./easyrsa --batch build-ca nopass

./easyrsa init-pki
./easyrsa gen-req server nopass

sudo cp ./pki/private/server.key /etc/openvpn/

./easyrsa gen-dh
openvpn --genkey --secret ta.key

sudo cp ./ta.key /etc/openvpn/
sudo cp ./pki/dh.pem /etc/openvpn/

mkdir -p ~/client-configs/keys
chmod -R 700 ~/client-configs

cd ~/EasyRSA-3.0.4/
./easyrsa gen-req client1 nopass

cp pki/private/client1.key ~/client-configs/keys/

{!! callback_event($server->id, 'server.configured', 100) !!}