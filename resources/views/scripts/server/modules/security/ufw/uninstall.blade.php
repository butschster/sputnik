
# ================================================
# Uninstall ufw
# ================================================
apt-get purge --auto-remove -y --force-yes ufw
apt-get autoremove
apt-get autoclean
