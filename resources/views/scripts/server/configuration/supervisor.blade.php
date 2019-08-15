
#Configure Supervisor
apt-get install -y --force-yes supervisor

systemctl enable supervisor.service
service supervisor start

chmod 777 /etc/supervisor/conf.d

@foreach($users as $user)
echo "{{ $user->name }} ALL=NOPASSWD: /usr/bin/supervisorctl *" > /etc/sudoers.d/supervisorctl
@endforeach
