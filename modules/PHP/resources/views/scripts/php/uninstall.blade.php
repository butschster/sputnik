@include('scripts.utils.wait_apt_unlock')

# ================================================
# Remove {!! $version !!}
# ================================================
apt-get purge -y --force-yes --auto-remove {!! $version !!}-common
