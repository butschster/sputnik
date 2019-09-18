
CLIENT={{ $user }}

cd /etc/openvpn/server/easy-rsa/
EASYRSA_CERT_EXPIRE=3650 ./easyrsa build-client-full $CLIENT nopass

echo "client
dev tun
proto {{ $configuration->protocol() }}
user nobody
group nogroup
sndbuf 0
rcvbuf 0
remote {{ $configuration->ip() }} {{ $configuration->port() }}
resolv-retry infinite
nobind
persist-key
persist-tun
remote-cert-tls server
cipher AES-256-CBC
auth SHA256
setenv opt block-outside-dns
key-direction 1
verb 3" > ~/$CLIENT.ovpn

echo "<ca>" >> ~/$CLIENT.ovpn
cat /etc/openvpn/server/easy-rsa/pki/ca.crt >> ~/$CLIENT.ovpn
echo "</ca>" >> ~/$CLIENT.ovpn
echo "<cert>" >> ~/$CLIENT.ovpn
sed -ne '/BEGIN CERTIFICATE/,$ p' /etc/openvpn/server/easy-rsa/pki/issued/$CLIENT.crt >> ~/$CLIENT.ovpn
echo "</cert>" >> ~/$CLIENT.ovpn
echo "<key>" >> ~/$CLIENT.ovpn
cat /etc/openvpn/server/easy-rsa/pki/private/$CLIENT.key >> ~/$CLIENT.ovpn
echo "</key>" >> ~/$CLIENT.ovpn
echo "<tls-auth>" >> ~/$CLIENT.ovpn
sed -ne '/BEGIN OpenVPN Static key/,$ p' /etc/openvpn/server/ta.key >> ~/$CLIENT.ovpn
echo "</tls-auth>" >> ~/$CLIENT.ovpn