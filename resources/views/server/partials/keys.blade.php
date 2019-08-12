<div class="card mt-3">
    <div class="card-header">
        <i class="fas fa-key fa-lg mr-3"></i> SSH keys
    </div>

    <table class="table mb-0">
        <col>
        <col width="300px">
        @foreach($server->keys as $key)
            <tr>
                <th>{{ $key->name }}</th>
                <td>{{ $key->fingerprint() }}</td>
            </tr>
        @endforeach
    </table>
    <div class="card-header">Store public key</div>
    <form action="{{ route('server.public_key.store', $server) }}" method="POST" class="card-body">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                   value="{{ old('name') }}" required autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Public key</label>
            <textarea type="text" class="form-control @error('content') is-invalid @enderror" name="content"></textarea>

            @error('content')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-primary">Store</button>
        </div>
    </form>
</div>
