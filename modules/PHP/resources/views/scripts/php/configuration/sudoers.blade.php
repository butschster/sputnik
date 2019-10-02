
# ================================================
# Configure Sudoers Entries
# ================================================
@foreach($users as $user)
echo "{{ $user->name }} ALL=NOPASSWD: /usr/sbin/service php{!! $version !!}-fpm reload" > /etc/sudoers.d/php-fpm
@endforeach
