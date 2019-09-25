
# ================================================
# Set The Timezone
# ================================================
ln -sf /usr/share/zoneinfo/{{ $timezone }} /etc/localtime

{!! callback_event($server->id, 'timezone.configured', 30) !!}