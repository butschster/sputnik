# ================================================
# Wait For Apt To Unlock
# ================================================
while fuser /var/lib/dpkg/lock >/dev/null 2>&1 ; do
    echo "Waiting for other software managers to finish..."
    sleep 1
done
while fuser /var/lib/apt/lists/lock >/dev/null 2>&1 ; do
    echo "Waiting for other software managers to finish..."
    sleep 1
done
if [ -f /var/log/unattended-upgrades/unattended-upgrades.log ]; then
    while fuser /var/log/unattended-upgrades/unattended-upgrades.log >/dev/null 2>&1 ; do
        sleep 1
    done
fi