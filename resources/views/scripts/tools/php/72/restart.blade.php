
# Restart PHP-FPM Services
if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
    then
    service php7.2-fpm restart > /dev/null 2>&1
fi

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'php72.restarted'], 10) !!}