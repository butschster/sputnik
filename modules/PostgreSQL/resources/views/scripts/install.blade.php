@include('scripts.utils.wait_apt_unlock')

# ================================================
# PostgreSQL
# ================================================

wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" >> /etc/apt/sources.list.d/pgdg.list'
apt-get update
apt-get install -y --force-yes postgresql postgresql-contrib

# ================================================
# Configure Postgres For Remote Access
# ================================================
sed -i "s/#listen_addresses = 'localhost'/listen_addresses = '{{ implode(',', $hosts) }}'/g" /etc/postgresql/11/main/postgresql.conf
echo "host    all             all             0.0.0.0/0               md5" | tee -a /etc/postgresql/11/main/pg_hba.conf

@foreach($users as $user)
@include('PostgreSQL::scripts.create_user', ['user' => $user])
@endforeach

# ================================================
# Configure The Timezone
# ================================================
sudo sed -i "s/localtime/UTC/" /etc/postgresql/11/main/postgresql.conf

service postgresql restart
