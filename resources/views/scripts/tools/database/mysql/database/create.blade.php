
mysql --user="root" --password="{!! $password !!}" -e "CREATE DATABASE IF NOT EXISTS {{ $database->name }} @if($database->character_set)character set {{ $database->character_set }}@endif @if($database->collation)collate {{ $database->collation }}@endif;"
@include('scripts.tools.database.mysql.user.create')