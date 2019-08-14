<div class="card mt-3">
    <div class="card-header">
        <i class="fas fa-database mr-3"></i> Server databases
    </div>

    <table class="table mb-0">
        <col>
        <col width="100px">
        <col width="100px">
        <col width="50px">
        <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Password</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        @foreach($server->databases as $database)
            <tr>
                <th>{{ $database->name }}</th>
                <td>{{ $server->database_password }}</td>
                <td><span class="badge badge-dark">{{ $database->taskStatus() }}</span></td>
                <td>
                    <form class="float-right" action="{{ route('server.database.delete', [$database->server_id, $database]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="card-header">Create a new one</div>
    <form action="{{ route('server.database.store', $server) }}" method="POST" class="card-body">
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

        <div class="form-group mb-0">
            <button class="btn btn-primary">Store</button>
        </div>
    </form>
</div>
