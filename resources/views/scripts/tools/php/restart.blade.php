
# ================================================
# Restart PHP-FPM Services
# ================================================
if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    service php{!! $version !!}-fpm restart > /dev/null 2>&1
fi
