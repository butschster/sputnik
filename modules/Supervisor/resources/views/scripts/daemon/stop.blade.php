
# ===========================================================================================
# Stop The Supervisor Daemon /etc/supervisor/conf.d/{!! $daemon->id !!}.conf
# ===========================================================================================

echo "Stopping Supervisor Group: {!! $daemon->id !!}"
supervisorctl stop {!! $daemon->id !!}:*
supervisorctl remove {!! $daemon->id !!}
rm /etc/supervisor/conf.d/{!! $daemon->id !!}.conf

supervisorctl reread
supervisorctl update