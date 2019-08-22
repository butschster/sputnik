@if($server->isConfigured())
    <div class="sidebar-section">
        <h5>Server</h5>
        <div class="nav">
            <a class="nav-link" href="{{ route('server.user.index', $server) }}">Users</a>
            <a class="nav-link" href="{{ route('server.firewall.index', $server) }}">Firewall</a>
            <a class="nav-link" href="{{ route('server.scheduler.index', $server) }}">Scheduler</a>
            <a class="nav-link" href="{{ route('server.supervisor.index', $server) }}">Supervisor</a>
            <a class="nav-link" href="{{ route('server.database.index', $server) }}">Database</a>

        </div>
    </div>
@endif