
export DEBIAN_FRONTEND=noninteractive

# Run Base Script

@include('scripts.server.configuration.base')

# Run PHP Installation Script

@include('scripts.tools.php.73.install')

# Run Nginx Installation Script

@include('scripts.tools.nginx.install')

# Run Node Installation Script

@include('scripts.tools.node.install')

# Run Database Installation Script

@include('scripts.tools.database.mysql.install')

# Run Redis Installation Script

@include('scripts.tools.redis.install')
