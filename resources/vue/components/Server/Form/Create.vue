<template>
    <div class="section">
        <div class="section-header">
            Create server

            <p>Standard virtual machines with a mix of memory and compute resources. Best for small projects that can handle variable levels of CPU performance, like blogs, web apps and dev/test environments.</p>
        </div>

        <form action="{{ route('server.store') }}" method="POST" class="card-body">
            @csrf

            <div class="flex">
                <div class="form-group form-group-labeled w-full is-required @error('name') is-invalid @enderror">
                    <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" autofocus placeholder="Server name">
                    <label for="name">Server name</label>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group form-group-labeled ml-5 w-full @error('team_id') is-invalid @enderror">
                    <select name="team_id" id="project" class="form-control">
                        @foreach($teams as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    <label for="project">Project</label>

                    @error('team_id')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="form-group form-group-labeled is-required w-full mr-5 @error('ip') is-invalid @enderror">
                    <input type="text" id="ip_address" class="form-control" name="ip" value="{{ old('ip', '167.71.3.113') }}" placeholder="IP Addrress">
                    <label for="ip_address">IP Addrress</label>

                    @error('ip')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group form-group-labeled is-required @error('port') is-invalid @enderror">
                    <input type="number" id="ssh_port" class="form-control" name="ssh_port" value="{{ old('port', 22) }}" placeholder="SSH port">
                    <label for="ssh_port">SSH port</label>

                    @error('port')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="form-group w-full form-group-labeled mr-5 @error('php_version') is-invalid @enderror">
                    <select name="php_version" id="php_version" class="form-control">
                        <option value="72">PHP 7.2</option>
                        <option value="73" selected>PHP 7.3</option>
                    </select>
                    <label for="php_version">PHP version</label>

                    @error('php_version')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group w-full form-group-labeled @error('database_type') is-invalid @enderror">
                    <select name="database_type" id="database_type" class="form-control">
                        <option value="mysql" selected>MySQL</option>
                        <option value="mariadb">MariaDB</option>
                        <option value="mysql8">MySQL 8</option>
                        <option value="pgsql">PostgreSQL</option>
                    </select>
                    <label for="database_type">Database</label>

                    @error('database_type')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <button class="btn btn-blue shadow-lg">
                <i class="fas fa-plus"></i>
                Create
            </button>
        </form>
    </div>
</template>

<script>
    export default {

    }
</script>
