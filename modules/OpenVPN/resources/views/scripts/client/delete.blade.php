
CLIENT={{ $name }}

cd /etc/openvpn/server/easy-rsa/
./easyrsa --batch revoke $CLIENT
EASYRSA_CRL_DAYS=3650 ./easyrsa gen-crl
rm -f pki/reqs/$CLIENT.req
rm -f pki/private/$CLIENT.key
rm -f pki/issued/$CLIENT.crt
rm -f /etc/openvpn/server/crl.pem

cp /etc/openvpn/server/easy-rsa/pki/crl.pem /etc/openvpn/server/crl.pem
# CRL is read with each client connection, when OpenVPN is dropped to nobody
chown nobody:nogroup /etc/openvpn/server/crl.pem

rm -f ~/$CLIENT.ovpn