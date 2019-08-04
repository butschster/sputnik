
# ================================================
# MySQL
#
# Documentation: https://dev.mysql.com/doc/
# ================================================

debconf-set-selections <<< "mysql-community-server mysql-community-server/data-dir select ''"
debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password {!! $databasePassword !!}"
debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password {!! $databasePassword !!}"

apt-get install -y mysql-server

# Configure Password Expiration

echo "default_password_lifetime = 0" >> /etc/mysql/mysql.conf.d/mysqld.cnf

# Configure Access Permissions For Root & Cloud Users

sed -i '/^bind-address/s/bind-address.*=.*/bind-address = */' /etc/mysql/mysql.conf.d/mysqld.cnf

mysql --user="root" --password="{!! $databasePassword !!}" -e "GRANT ALL ON *.* TO root@'localhost' IDENTIFIED BY '{!! $databasePassword !!}';"
mysql --user="root" --password="{!! $databasePassword !!}" -e "GRANT ALL ON *.* TO root@'%' IDENTIFIED BY '{!! $databasePassword !!}';"

service mysql restart

mysql --user="root" --password="{!! $databasePassword !!}" -e "CREATE USER 'sputnik'@'localhost' IDENTIFIED BY '{!! $databasePassword !!}';"
mysql --user="root" --password="{!! $databasePassword !!}" -e "CREATE USER 'sputnik'@'%' IDENTIFIED BY '{!! $databasePassword !!}';"
mysql --user="root" --password="{!! $databasePassword !!}" -e "GRANT ALL ON *.* TO 'sputnik'@'localhost' IDENTIFIED BY '{!! $databasePassword !!}' WITH GRANT OPTION;"
mysql --user="root" --password="{!! $databasePassword !!}" -e "GRANT ALL ON *.* TO 'sputnik'@'%' IDENTIFIED BY '{!! $databasePassword !!}' WITH GRANT OPTION;"
mysql --user="root" --password="{!! $databasePassword !!}" -e "FLUSH PRIVILEGES;"
