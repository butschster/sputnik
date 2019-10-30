@include('scripts.utils.wait_apt_unlock')

# ================================================
# Install Fail2Ban
# ================================================
apt-get install -y --force-yes fail2ban
