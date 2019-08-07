
# Setup UFW Firewall

apt-get install -y --force-yes ufw

@foreach($ports as $port)
ufw allow {{ $port }}
@endforeach

ufw --force enable
