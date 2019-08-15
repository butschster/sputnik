
sudo -u postgres psql -c "CREATE ROLE {{ $user->name }} LOGIN PASSWORD '{!! $password !!}' SUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;"
