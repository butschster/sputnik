
# ================================================
# Schedule new cron job
# ================================================

echo "" | tee -a /etc/crontab
echo '{{ $job->crontabName() }}' | tee -a /etc/crontab
echo '{{ $job->cron }} {{ $job->user }} {!! $job->command !!} > {{ $job->logsPath() }} 2>&1' | tee -a /etc/crontab
