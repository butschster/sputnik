
# ================================================
# Restart The Supervisor Daemon
# ================================================

supervisorctl restart {!! $daemon->id !!}:*
