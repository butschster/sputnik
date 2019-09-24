
# ================================================
# Uninstall PostgreSQL
# ================================================

apt-get purge --auto-remove -y --force-yes postgresql*
apt-get autoremove
apt-get autoclean
