@include('scripts.utils.wait_apt_unlock')

# ================================================
# Uninstall Nginx
# ================================================

apt-get purge --auto-remove -y --force-yes nginx*
apt-get autoremove
apt-get autoclean
