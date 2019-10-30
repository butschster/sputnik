@include('scripts.utils.wait_apt_unlock')

# ================================================
# Install {{ $version }}
#
# Documentation: https://www.php.net/
# ================================================
apt-add-repository ppa:ondrej/php -y
apt-get update

apt-get update

apt-get install -y --force-yes {{ implode(' ', $server_modules) }}

@foreach($modules_configuration as $configuration)
{!! $configuration !!}
@endforeach

@include('PHP::scripts.php.configuration.sudoers')
