
# Set The Proper Directory Permissions

chown -R sputnik:sputnik /home/sputnik
chmod -R 755 /home/sputnik

chmod 700 /home/sputnik/.ssh
chmod 700 /home/sputnik/.ssh/authorized_keys.d

chmod 644 /home/sputnik/.ssh/authorized_keys.d/*
chmod 644 /home/sputnik/.ssh/authorized_keys
chmod 644 /home/sputnik/.ssh/id_rsa.pub
chmod 600 /home/sputnik/.ssh/id_rsa
