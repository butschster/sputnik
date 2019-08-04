
export DEBIAN_FRONTEND=noninteractive

# Run Base Script

@include('scripts.server.configuration.base')

# Run Caddy Installation Script

@include('scripts.tools.caddy.install')

# Run PHP Installation Script

@include('scripts.tools.php.install')

# Run Node Installation Script

@include('scripts.tools.node.install')

# Run Database Installation Script

@include('scripts.tools.database.install')

# Run Redis Installation Script

@include('scripts.tools.redis.install')
