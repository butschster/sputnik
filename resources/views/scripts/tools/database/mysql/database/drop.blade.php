
mysql --user="root" --password="{!! $password !!}" -e "DROP DATABASE IF EXISTS {{ $database->name }};"
@include('scripts.tools.database.mysql.user.remove')