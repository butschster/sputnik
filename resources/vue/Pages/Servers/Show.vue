<template>
    <div>
        <Loader :loading="loading" />
        <div v-if="server">
            <h1 class="mb-4">
                <i class="fas fa-hdd mr-3"></i> {{ server.name }}

                <span class="badge float-right @if($server->isConfigured()) badge-success @else badge-warning @endif">
                {{ server.status }}
            </span>
            </h1>




            <h4>System information</h4>

            <table class="table">
                <col width="200px">
                <col>
                @if($sysInfo)
                <tr>
                    <th>OS</th>
                    <td>
                        {{ $sysInfo->getOs() }}
                        {{ $sysInfo->getVersion() }}
                        [{{ $sysInfo->getArchitecture() }} bits]

                        @if($sysInfo->isSupported())
                        <span class="badge badge-success">Supported</span>
                        @else
                        <span class="badge badge-danger">Not supported</span>
                        @endif
                    </td>
                </tr>
                @endif
                <tr>
                    <th>SSH Port</th>
                    <td>{{ $server->ssh_port }}</td>
                </tr>
                <tr>
                    <th>IP Address</th>
                    <td>{{ $server->ip }}</td>
                </tr>
                <tr>
                    <th>PHP Version</th>
                    <td>{{ $server->php_version }} </td>
                </tr>
                <tr>
                    <th>Database</th>
                    <td>{{ $server->database_type }}</td>
                </tr>
                <tr>
                    <th>Webserver</th>
                    <td>{{ $server->webserver_type }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        components: {},
        data() {
            return {
                server: null,
                loading: false,
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.server.show', {server: this.$route.params.id}).request()
                    this.server = response.data.data
                } catch (e) {
                    console.error(e)
                    this.$router.replace({name: "404"})
                }

                this.loading = false
            }
        },
        watch: {
            '$route': 'load'
        }
    }
</script>
