<div class="nav flex-column nav-pills card mb-4">
    <div class="card-header">
        Manage site
    </div>
    <a class="nav-link" href="{{ route('server.site.environment.index', [$site->server_id, $site]) }}">Environment</a>
    <a class="nav-link" href="{{ route('server.site.deployments.index', [$site->server_id, $site]) }}">Deployments</a>
</div>
