
# ================================================
# Install NodeJS
#
# Documentation: https://nodejs.org/en/docs/
# ================================================
curl --silent --location https://deb.nodesource.com/setup_{{$version}}.x | bash -
apt-get update
apt-get install -y --force-yes nodejs
