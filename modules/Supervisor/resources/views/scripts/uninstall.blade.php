@include('scripts.utils.wait_apt_unlock')

# ================================================
# Uninstall Supervisor
# ================================================
apt-get purge --auto-remove -y --force-yes supervisor
apt-get autoremove
apt-get autoclean

