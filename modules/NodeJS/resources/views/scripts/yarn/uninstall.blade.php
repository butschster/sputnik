@include('scripts.utils.wait_apt_unlock')

# ================================================
# Uninstall Yarn
# ================================================
apt-get purge --auto-remove -y --force-yes yarn
apt-get autoremove
apt-get autoclean

