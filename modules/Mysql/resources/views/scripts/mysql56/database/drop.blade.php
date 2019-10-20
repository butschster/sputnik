
mysql --user="{!! $user->getName() !!}" --password="{!! $user->getPassword() !!}" -e "DROP DATABASE IF EXISTS {{ $database }};"
@include('Mysql::scripts.mysql56.user.remove')
