@include('scripts.utils.wait_apt_unlock')

# ================================================
# Install Yarn
#
# Documentation: https://yarnpkg.com/en/docs
# ================================================
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list

apt-get update
apt-get install -y --force-yes yarn
