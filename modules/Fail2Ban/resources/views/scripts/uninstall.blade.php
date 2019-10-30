@include('scripts.utils.wait_apt_unlock')

# ================================================
# Uninstall Fail2Ban
# ================================================
apt-get purge --auto-remove -y --force-yes fail2ban
apt-get autoremove
apt-get autoclean
