@include('scripts.utils.wait_apt_unlock')

# ================================================
# Uninstall Redis
# ================================================
apt-get purge --auto-remove -y --force-yes redis-server
apt-get autoremove
apt-get autoclean

