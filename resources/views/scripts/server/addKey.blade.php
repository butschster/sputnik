
# Write Key & Regenerate Keys File

cat > /home/sputnik/.ssh/authorized_keys.d/{{ $name }} << EOF
{{ $key }}
EOF

cat /home/sputnik/.ssh/authorized_keys.d/* > /home/sputnik/.ssh/authorized_keys
