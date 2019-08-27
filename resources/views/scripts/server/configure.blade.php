
export DEBIAN_FRONTEND=noninteractive

# Run Base Script

@include('scripts.server.configuration.base')

# Run PHP Installation Script
{!! $configurator->php()->install() !!}

# Run Webserver Installation Script
{!! $configurator->webserver()->install() !!}


# Run Database Installation Script
{!! $configurator->database()->install() !!}

{{--
# Run Node Installation Script

@include('scripts.tools.node.install')
--}}

# Run Redis Installation Script

@include('scripts.tools.redis.install')

{!! callback_event($server->id, 'server.configured', 100) !!}