<div class="card mt-4">
    <div class="card-header">
        Create site
    </div>
    <form action="{{ route('server.site.store', $server) }}" method="POST" class="card-body">
        @csrf

        <div class="form-group">
            <label>Domain</label>
            <input type="text" class="form-control @error('domain') is-invalid @enderror" name="domain"
                   value="{{ old('domain') }}" required autofocus>

            @error('domain')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Public dir</label>
            <input type="text" class="form-control @error('public_dir') is-invalid @enderror" name="public_dir"
                   value="{{ old('public_dir', '/public') }}" required autofocus>

            @error('public_dir')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Create</button>
        </div>
    </form>
</div>
