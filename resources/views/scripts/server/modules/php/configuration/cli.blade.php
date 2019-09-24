
# ================================================
# Configure PHP CLI
# ================================================
cat > /etc/php/{!! $version !!}/cli/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/server/modules/php/configuration/cli.ini')) !!}
EOF
