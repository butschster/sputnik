@if($server->isConfigured())
    <div class="sidebar-section">
        <h5>Sites</h5>
        @if($server->sites->count() > 0)
            <div class="nav">
                @foreach($server->sites as $site)
                    <a class="nav-link" href="{{ route('server.site.show', ['server' => $server, 'site' => $site]) }}">
                        {{ $site->domain }}
                    </a>
                @endforeach
                <a class="nav-link" href="#">
                    Manage
                </a>
            </div>
        @endif

        @can('store', [\App\Models\Server\Site::class, $server])
            <h5>Create site</h5>
            <form action="{{ route('server.site.store', $server) }}" method="POST">
                @csrf

                <div class="form-group form-group-labeled">
                    <input type="text" class="form-control @error('domain') is-invalid @enderror" id="domain"
                           name="domain"
                           value="{{ old('domain') }}" placeholder="Domain" autofocus>
                    <label for="domain">Domain</label>

                    @error('domain')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>

                <div class="form-group form-group-labeled">
                    <input type="text" class="form-control @error('public_dir') is-invalid @enderror"
                           placeholder="Public dir" id="public_dir" name="public_dir"
                           value="{{ old('public_dir', '/public') }}">
                    <label for="public_dir">Public dir</label>

                    @error('public_dir')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>

                <div class="form-group mt-8">
                    <button class="btn btn-primary btn-rounded">
                        <i class="fas fa-plus"></i>
                        Create
                    </button>
                </div>
            </form>
        @endcan
    </div>
@endif
