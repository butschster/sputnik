
@mysql(['user' => $root])
CREATE DATABASE IF NOT EXISTS {{ $database->getName() }} @if($database->getCharacterSet())character set {{ $database->getCharacterSet() }}@endif @if($database->getCollation())collate {{ $database->getCollation() }}@endif
@endmysql
@include('Mysql::scripts.mysql56.user.create', ['user' => $database->getUser(), 'hosts' => $database->getHosts()] )

