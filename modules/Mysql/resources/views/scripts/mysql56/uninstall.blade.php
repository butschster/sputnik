
# ================================================
# Uninstall MySQL
# ================================================

apt-get purge --auto-remove -y --force-yes mysql*
apt-get autoremove
apt-get autoclean