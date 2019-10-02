
# ================================================
# Stop The Supervisor Daemon
# ================================================

echo "Stopping Supervisor Group: {!! $id !!}"
supervisorctl stop {!! $id !!}:*
supervisorctl remove {!! $id !!}
rm /etc/supervisor/conf.d/{!! $id !!}.conf

supervisorctl reread
supervisorctl update