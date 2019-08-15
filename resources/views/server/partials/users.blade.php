<div class="card mt-3">
    <div class="card-header">
        <i class="fas fa-users fa-lg mr-3"></i> Server users
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
            <th>Home</th>
            <th></th>
        </tr>
        </thead>
        @foreach($server->users as $user)
            <tr>
                <th>{{ $user->name }}</th>
                <td>{{ $user->sudo_password }}</td>
                <td>{{ $user->homeDir() }}</td>
                <td>
                    @if(!$user->isSystem())
                        <form class="float-right" action="{{ route('server.user.delete', [$server, $user]) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    @if($server->isConfigured())
        <div class="card-header">Create a new user</div>
        <form action="{{ route('server.user.store', $server) }}" method="POST" class="card-body">
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
    @endif
</div>
