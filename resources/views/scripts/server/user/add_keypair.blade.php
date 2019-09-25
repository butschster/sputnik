
# ================================================
# Generate Authorized Keys File
# ================================================
echo "{!! $user->public_key !!}" > {{ $user->homeDir() }}/.ssh/authorized_keys.d/user.pub
echo "{!! $user->public_key !!}" > {{ $user->homeDir() }}/.ssh/user.pub
echo "{!! $user->private_key !!}" > {{ $user->homeDir() }}/.ssh/user
cat {{ $user->homeDir() }}/.ssh/authorized_keys.d/* > {{ $user->homeDir() }}/.ssh/authorized_keys
