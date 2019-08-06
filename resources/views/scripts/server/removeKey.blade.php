
# ================================================
# Remove Key & Regenerate Keys File
# ================================================

rm -f /home/sputnik/.ssh/authorized_keys.d/{{ $name }}

cat /home/sputnik/.ssh/authorized_keys.d/* > /home/sputnik/.ssh/authorized_keys
