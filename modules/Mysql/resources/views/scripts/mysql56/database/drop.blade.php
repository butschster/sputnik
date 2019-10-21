
@mysql(['user' => $root])
DROP DATABASE IF EXISTS {{ $database->getName() }}
@endmysql

@include('Mysql::scripts.mysql56.user.remove', ['user' => $database->getUser(), 'hosts' => $database->getHosts()])
