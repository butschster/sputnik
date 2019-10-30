
# ================================================
# Create configuration for site {{ $site->getDomain() }}
# ================================================

{!! $webserver->createScript($processor, $site) !!}