@include('scripts.utils.wait_apt_unlock')

# ================================================
# Uninstall MongoDB
# ================================================
apt-get purge --auto-remove -y --force-yes mongodb-server
apt-get autoremove
apt-get autoclean
