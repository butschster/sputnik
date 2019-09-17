<template>
    <div class="section well well-lg">
            <div class="section-header">
            Connect server

            <p>You can connect any server with public IP address and opened ssh port. Your server must run a fresh
                installation of Ubuntu 18.04 x64 and must have a root user.</p>
        </div>

        <div class="section-body" v-if="$gate.allow('create', 'server')">
            <FormSelect v-model="type" label="Server type" :options="types" />
            <component :is="type"></component>
        </div>
        <div v-else class="alert alert-primary">
            <p>Upgrade your subscription to connect more servers</p>
        </div>
    </div>
</template>

<script>
    import FormSelect from '@vue/components/Form/Select'
    import webserver from "@vue/components/Server/Form/Type/WebServer"
    import openvpn from "@vue/components/Server/Form/Type/OpenVPN"

    export default {
        components: {FormSelect, webserver, openvpn},
        data() {
            return {
                type: 'webserver',
                types: [
                    {
                        label: 'Web server',
                        value: 'webserver'
                    },
                    {
                        label: 'OpenVPN server',
                        value: 'openvpn'
                    },
                ]
            }
        },
        mounted() {

        },
        methods: {

        },
        computed: {

        }
    }
</script>
