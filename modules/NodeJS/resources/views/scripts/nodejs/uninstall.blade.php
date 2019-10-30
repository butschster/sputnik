@include('scripts.utils.wait_apt_unlock')

# ================================================
# Uninstall NodeJS
# ================================================
apt-get purge --auto-remove -y --force-yes nodejs
apt-get autoremove
apt-get autoclean

