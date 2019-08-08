
# ================================================
# MySQL 8
#
# Documentation: https://dev.mysql.com/doc/
# ================================================

wget -c https://dev.mysql.com/get/mysql-apt-config_0.8.12-1_all.deb
dpkg --install mysql-apt-config_0.8.12-1_all.deb

debconf-set-selections <<< "mysql-community-server mysql-community-server/data-dir select ''"
debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password {!! $password !!}"
debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password {!! $password !!}"

apt-get update

apt-get install -y mysql-server

# Configure Password Expiration

echo "default_password_lifetime = 0" >> /etc/mysql/mysql.conf.d/mysqld.cnf

# Configure Access Permissions For Root & Sputnik Users

sed -i '/^bind-address/s/bind-address.*=.*/bind-address = */' /etc/mysql/mysql.conf.d/mysqld.cnf

mysql --user="root" --password="{!! $password !!}" -e "GRANT ALL ON *.* TO root@'localhost' IDENTIFIED BY '{!! $password !!}';"
mysql --user="root" --password="{!! $password !!}" -e "FLUSH PRIVILEGES;"

@foreach($users as $user)
@include('scripts.tools.database.mysql.create_user', ['user' => $user])
@endforeach
