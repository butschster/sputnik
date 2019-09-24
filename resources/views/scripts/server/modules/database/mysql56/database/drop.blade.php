
mysql --user="root" --password="{!! $password !!}" -e "DROP DATABASE IF EXISTS {{ $database->name }};"
@include('scripts.server.modules.database.mysql56.user.remove')
