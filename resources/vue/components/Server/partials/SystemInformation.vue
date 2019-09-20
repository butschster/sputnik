<template>
    <section class="section">
        <div class="section-header">
            {{ $t('server.settings.system_information') }}
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
            <tr v-for="(value, key) in server.configuration" :key="key">
                <th>{{ $t(`server.configuration.${key}`) }}</th>
                <td>{{ value }}</td>
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
