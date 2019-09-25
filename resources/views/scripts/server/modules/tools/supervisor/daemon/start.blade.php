
# ================================================
# Write The Supervisor Configuration
# ================================================

cat > /etc/supervisor/conf.d/{!! $id !!}.conf << EOF
[program:{{ $id }}]
process_name=%(program_name)s_%(process_num)02d
command={{ $command }}
user={{ $user }}
autostart=true
autorestart=true
startsecs=3
startretries=3
stopsignal=TERM
numprocs={!! $processes !!}
redirect_stderr=true
stdout_logfile=/var/log/supervisor/{!! $id !!}.stdout
stderr_logfile=/var/log/supervisor/{!! $id !!}.stderr
stdout_logfile_maxbytes=10MB
stderr_logfile_maxbytes=10MB

EOF

supervisorctl reread
supervisorctl update
supervisorctl start {!! $id !!}:*