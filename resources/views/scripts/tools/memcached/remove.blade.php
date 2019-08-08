
# ================================================
# Uninstall Memcached
# ================================================

apt-get purge --auto-remove -y --force-yes memcached
apt-get autoremove
apt-get autoclean

