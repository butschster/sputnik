
# ================================================
# Uninstall MariaDB
# ================================================

apt-get purge --auto-remove -y --force-yes mariadb*
apt-get autoremove
apt-get autoclean
