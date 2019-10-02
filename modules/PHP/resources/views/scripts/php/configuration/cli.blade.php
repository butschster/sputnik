
# ================================================
# Configure PHP CLI
# ================================================
cat > /etc/php/{!! $version !!}/cli/php.ini << EOF
{!! file_get_contents(modules_path('PHP/resources/views/scripts/php/configuration/cli.ini')) !!}
EOF
