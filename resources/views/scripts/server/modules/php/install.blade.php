
# ================================================
# PHP {{ $version }}
#
# Documentation: https://www.php.net/
# ================================================
apt-add-repository ppa:ondrej/php -y
apt-get update

apt-get update

apt-get install -y --force-yes {{ implode(' ', $server_modules) }}

@foreach($modules as $module)
    @includeIf(view()->exists('scripts.server.modules.php.configuration.'.$module), 'scripts.server.modules.php.configuration.'.$module)
@endforeach

@include('scripts.server.modules.php.configuration.sudoers')
