
# ================================================
# Delete configuration for site {{ $site->getDomain() }}
# ================================================

{!! $webserver->deleteScript($processor, $site) !!}