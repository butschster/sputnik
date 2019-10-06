
# ===========================================================================================
# Create The Supervisor Daemon /etc/supervisor/conf.d/{!! $daemon->id !!}.conf
# ===========================================================================================

cat > /etc/supervisor/conf.d/{!! $daemon->id !!}.conf << EOF
[program:{{ $daemon->id }}]
process_name=%(program_name)s_%(process_num)02d
command={{ $daemon->command }}
user={{ $daemon->user }}
autostart=true
autorestart=true
startsecs=3
startretries=3
stopsignal=TERM
numprocs={!! $daemon->processes !!}
redirect_stderr=true
stdout_logfile=/var/log/supervisor/{!! $daemon->id !!}.stdout
stderr_logfile=/var/log/supervisor/{!! $daemon->id !!}.stderr
stdout_logfile_maxbytes=10MB
stderr_logfile_maxbytes=10MB

EOF

supervisorctl reread
supervisorctl update
supervisorctl start {!! $daemon->id !!}:*