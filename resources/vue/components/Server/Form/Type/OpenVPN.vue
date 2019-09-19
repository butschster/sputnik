<template>
    <div>
        <div class="flex">
            <FormInput v-model="form.vpn_port"
                       :label="$t('server.form.create.label.vpn_port')"
                       name="vpn_port"
                       class="w-full mr-8"
                       required/>

            <FormSelect v-model="form.vpn_protocol"
                        :label="$t('server.form.create.label.vpn_protocol')"
                        name="vpn_protocol"
                        class="w-full"
                        :options="protocols"
                        required/>
        </div>

        <div class="flex">
            <FormSelect v-model="form.dns"
                        :label="$t('server.form.create.label.vpn_dns')"
                        name="dns"
                        class="w-full"
                        :options="dns_resolvers" required/>
        </div>

        <button class="btn btn-primary shadow-lg" @click="onSubmit">
            <i class="fas fa-plus"></i>
            {{ $t('server.form.create.button.create') }}
        </button>
    </div>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'
    import FormSelect from '@vue/components/Form/Select'

    export default {
        components: {FormInput, FormSelect},
        props: {
            loading: {
                type: Boolean,
                default: false
            },
            server: Object
        },
        data() {
            return {
                form: {
                    vpn_port: 1194,
                    vpn_protocol: 'udp',
                    dns: 'current'
                },
                protocols: [
                    {
                        label: 'UPD',
                        value: 'udp'
                    },
                    {
                        label: 'TCP',
                        value: 'tcp'
                    },
                ],
                dns_resolvers: [
                    {
                        label: 'Current system resolvers',
                        value: 'current'
                    },
                    {
                        label: 'Google',
                        value: 'google'
                    },
                    {
                        label: 'OpenDNS',
                        value: 'opendns'
                    },
                    {
                        label: 'Verisign',
                        value: 'verisign'
                    },
                ]
            }
        },
        methods: {
            async onSubmit() {
                this.$emit('submit', this.form)
            }
        }
    }
</script>
