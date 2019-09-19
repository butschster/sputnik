
# ================================================
# Uninstall server public keys
# ================================================

rm -rf /root/.ssh/authorized_keys.d/server.pub
sed -i "{!! $server->public_key !!}" /root/.ssh/authorized_keys