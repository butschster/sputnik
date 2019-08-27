<template>
    <div>
        <h4>System information</h4>

        <table class="table">
            <col width="200px">
            <col>
            <tbody>
            <tr v-if="hasSysInfo">
                <th>OS</th>
                <td>
                    {{ server.sys_info.os }}
                    {{ server.sys_info.version }}
                    [{{ server.sys_info.architecture }} bits]

                    <span class="badge badge-success" v-if="server.sys_info.is_supported">Supported</span>
                    <span class="badge badge-danger" v-else>Not supported</span>
                </td>
            </tr>
            <tr>
                <th>SSH Port</th>
                <td>{{ server.ssh_port }}</td>
            </tr>
            <tr>
                <th>IP Address</th>
                <td>{{ server.ip }}</td>
            </tr>
            <tr>
                <th>PHP Version</th>
                <td>{{ server.php_version }}</td>
            </tr>
            <tr>
                <th>Database</th>
                <td>{{ server.database_type }}</td>
            </tr>
            <tr>
                <th>Webserver</th>
                <td>{{ server.webserver_type }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: {
            server: Object
        },
        mounted() {
            this.$echo.channel('server').listen('')
        },
        computed: {
            hasSysInfo() {
                return typeof this.server.sys_info != 'undefined'
            }
        }
    }
</script>