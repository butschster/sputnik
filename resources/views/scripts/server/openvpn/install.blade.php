
# Get easy-rsa
EASYRSAURL='https://github.com/OpenVPN/easy-rsa/releases/download/v3.0.6/EasyRSA-unix-v3.0.6.tgz'

wget -O ~/easyrsa.tgz "$EASYRSAURL" 2>/dev/null || curl -Lo ~/easyrsa.tgz "$EASYRSAURL"
tar xzf ~/easyrsa.tgz -C ~/


mv ~/EasyRSA-v3.0.6/ /etc/openvpn/server/
mv /etc/openvpn/server/EasyRSA-v3.0.6/ /etc/openvpn/server/easy-rsa/
chown -R root:root /etc/openvpn/server/easy-rsa/

rm -f ~/easyrsa.tgz
cd /etc/openvpn/server/easy-rsa/

cp vars.example vars

@foreach($configuration->vars() as $key => $value)
sed -i 's/.*set_var {{ $key }}.*/set_var {{ $key }}="{{ $value }}"/g' vars
@endforeach

# Create the PKI, set up the CA and the server and client certificates
./easyrsa init-pki

# Workaround to remove unharmful error until easy-rsa 3.0.7
# https://github.com/OpenVPN/easy-rsa/issues/261
sed -i 's/^RANDFILE/#RANDFILE/g' /etc/openvpn/server/easy-rsa/pki/openssl-easyrsa.cnf

./easyrsa --batch build-ca nopass

EASYRSA_CERT_EXPIRE=3650 ./easyrsa build-server-full server nopass
EASYRSA_CRL_DAYS=3650 ./easyrsa gen-crl

# Move the stuff we need
cp pki/ca.crt pki/private/ca.key pki/issued/server.crt pki/private/server.key pki/crl.pem /etc/openvpn/server

# CRL is read with each client connection, when OpenVPN is dropped to nobody
chown nobody:nogroup /etc/openvpn/server/crl.pem

# Generate key for tls-auth
openvpn --genkey --secret /etc/openvpn/server/ta.key

./easyrsa gen-dh
cp /etc/openvpn/server/easy-rsa/pki/dh.pem /etc/openvpn/server/dh.pem

# Generate server.conf
echo "port {{ $configuration->port() }}
proto {{ $configuration->protocol() }}
dev tun
sndbuf 0
rcvbuf 0
ca ca.crt
cert server.crt
key server.key
dh dh.pem
auth SHA256
tls-auth ta.key 0
server 10.8.0.0 255.255.255.0
ifconfig-pool-persist ipp.txt" > /etc/openvpn/server/server.conf

echo 'push "redirect-gateway def1 bypass-dhcp"' >> /etc/openvpn/server/server.conf

@if(empty($configuration->dns()))
# Locate the proper resolv.conf
# Needed for systems running systemd-resolved
if grep -q "127.0.0.53" "/etc/resolv.conf"; then
    RESOLVCONF='/run/systemd/resolve/resolv.conf'
else
    RESOLVCONF='/etc/resolv.conf'
fi

# Obtain the resolvers from resolv.conf and use them for OpenVPN
grep -v '#' $RESOLVCONF | grep 'nameserver' | grep -E -o '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}' | while read line; do
echo "push \"dhcp-option DNS $line\"" >> /etc/openvpn/server/server.conf
done
@else
@foreach($configuration->dns() as $ip)
echo 'push "dhcp-option DNS {{ $ip }}"' >> /etc/openvpn/server/server.conf
@endforeach
@endif

echo "keepalive 10 120
cipher AES-256-CBC
user nobody
group nogroup
persist-key
persist-tun
status openvpn-status.log
verb 3
crl-verify crl.pem
explicit-exit-notify {{ $configuration->protocol() == 'tcp' ? 0 : 1 }}" >> /etc/openvpn/server/server.conf

# Enable net.ipv4.ip_forward for the system
echo 'net.ipv4.ip_forward=1' > /etc/sysctl.d/30-openvpn-forward.conf

# Enable without waiting for a reboot or service restart
echo 1 > /proc/sys/net/ipv4/ip_forward

read -r -d '' NAT_RULES << EOM
# START OPENVPN RULES
*nat
:POSTROUTING ACCEPT [0:0]
-A POSTROUTING -s 10.8.0.0/8 -o eth0 -j MASQUERADE
COMMIT
# END OPENVPN RULES
EOM

echo -e "$NAT_RULES\n$(cat /etc/ufw/before.rules)" > /etc/ufw/before.rules

sed -i 's/DEFAULT_FORWARD_POLICY=.*/DEFAULT_FORWARD_POLICY="ACCEPT"/g' /etc/default/ufw

# And finally, enable and start the OpenVPN service
systemctl enable --now openvpn-server@server.service