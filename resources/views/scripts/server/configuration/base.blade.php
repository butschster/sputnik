
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
ufw \
software-properties-common \
supervisor \
whois \
unzip

# Disable Password Authentication Over SSH
sed -i "/PasswordAuthentication yes/d" /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "PasswordAuthentication no" | sudo tee -a /etc/ssh/sshd_config

# Restart SSH
ssh-keygen -A
service ssh restart

# Set The Hostname

echo "{!! $server->name !!}" > /etc/hostname
sed -i 's/127\.0\.0\.1.*localhost/127.0.0.1 {!!$server->name !!} localhost/' /etc/hosts
hostname {!! $server->name !!}

# Set The Timezone

ln -sf /usr/share/zoneinfo/UTC /etc/localtime

# Create The Root SSH Directory If Necessary

# Setup Sputnik User

useradd sputnik
mkdir -p /home/sputnik/.ssh
mkdir -p /home/sputnik/.sputnik
adduser sputnik sudo

# Setup Bash For The Sputnik User

chsh -s /bin/bash sputnik
cp /root/.profile /home/sputnik/.profile
cp /root/.bashrc /home/sputnik/.bashrc

# Set The Sudo Password For The Sputnik User

PASSWORD=$(mkpasswd {!! $server->sudo_password !!})
usermod --password $PASSWORD sputnik

# Build SSH Key Directories

mkdir -p /home/sputnik/.ssh/authorized_keys.d

# Generate Authorized Keys File

echo "{!! $server->public_key !!}" > /home/sputnik/.ssh/authorized_keys.d/server.pub
cat /home/sputnik/.ssh/authorized_keys.d/* > /home/sputnik/.ssh/authorized_keys

# Create The Server SSH Key

ssh-keygen -f /home/sputnik/.ssh/id_rsa -t rsa -N ''

# Configure Supervisor

systemctl enable supervisor.service
service supervisor start

chmod 777 /etc/supervisor/conf.d

echo "sputnik ALL=NOPASSWD: /usr/bin/supervisorctl *" > /etc/sudoers.d/supervisorctl

# Setup UFW Firewall

ufw allow {{ $server->ssh_port }}
ufw --force enable

# Configure Swap Disk

if [ -f /swapfile ]; then
echo "Swap exists."
else
fallocate -l 1G /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo "/swapfile none swap sw 0 0" >> /etc/fstab
echo "vm.swappiness=30" >> /etc/sysctl.conf
echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
fi

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

@include('scripts.tools.chown')

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'base.installed'], 10) !!}
