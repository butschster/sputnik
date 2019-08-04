
# Install Packages

apt-get install -y --force-yes supervisor
curl https://getcaddy.com | bash

# Configure Supervisor Autostart

systemctl enable supervisor.service
service supervisor start

# Allow Caddy To Bind To Root Privileged Ports

setcap cap_net_bind_service=+ep $(which caddy)

# Create Caddy Directories

mkdir /home/sputnik/.caddy

# Write The Caddy Supervisor Configuration

#  -ca "https://acme-staging.api.letsencrypt.org/directory"

cat > /etc/supervisor/conf.d/caddy.conf << EOF
[program:caddy]
command=/usr/local/bin/caddy -conf="/home/sputnik/Caddyfile" -pidfile="/home/sputnik/caddy.pid" -log="/home/sputnik/caddy.log" -agree -email="letsencrypt@sputnik.com"
user=sputnik
environment=HOME="/home/sputnik",CADDYPATH="/home/sputnik/.caddy"
autostart=true
autorestart=unexpected
exitcodes=0,2
startsecs=1
startretries=3
stopsignal=QUIT
stopwaitsecs=10
stopasgroup=false
redirect_stderr=true
stdout_logfile=/home/sputnik/caddy.stdout
stderr_logfile=/home/sputnik/caddy.stderr
EOF
