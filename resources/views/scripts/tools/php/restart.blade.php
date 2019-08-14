
# ================================================
# Restart PHP-FPM Services
# ================================================
if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    systemctl restart php{!! $version !!}-fpm > /dev/null 2>&1
fi
