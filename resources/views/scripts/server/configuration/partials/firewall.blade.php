
# Setup UFW Firewall
@foreach($ports as $port)
ufw allow {{ $port }}
@endforeach