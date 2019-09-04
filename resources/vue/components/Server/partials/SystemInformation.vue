<template>
    <section class="section">
        <div class="section-header">
            System information
        </div>
        <table class="table">
            <col width="200px">
            <col>
            <tbody>
            <tr v-if="hasSysInfo">
                <th>OS</th>
                <td>
                    {{ server.sys_info.name }}

                    <span class="badge badge-success" v-if="isSupported">Supported</span>
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
    </section>
</template>

<script>
    import serverMixin from "@js/vue/mixins/server"
    export default {
        mixins: [serverMixin],
        props: {
            server: Object
        }
    }
</script>