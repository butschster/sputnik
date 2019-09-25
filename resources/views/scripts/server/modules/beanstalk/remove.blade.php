
# ================================================
# Uninstall Beanstalk
# ================================================

apt-get purge --auto-remove -y --force-yes beanstalkd
apt-get autoremove
apt-get autoclean

