<template>
    <div>
        <Loader :loading="loading"/>
        <div class="flex">
            <FormInput v-model="form.name" :label="label.name" name="name" class="w-full" required autofocus/>
            <FormSelect v-if="teams.length > 1" v-model="form.team_id" :label="label.team" name="team_id"
                        class="ml-8 w-full" :options="teams" required/>
        </div>

        <div class="flex">
            <FormInput v-model="form.ip" :label="label.ip" name="ip" class="w-full mr-8" required/>
            <FormInput v-model="form.ssh_port" :label="label.ssh_port" name="ssh_port" required/>
        </div>

        <div class="flex">
            <FormInput v-model="form.vpn_port" label="What port do you want OpenVPN listening to" name="vpn_port" class="w-full mr-8" required/>
            <FormSelect v-model="form.vpn_protocol" label="Which DNS do you want to use with the VPN" name="vpn_protocol" class="w-full"
                        :options="protocols" required/>
        </div>

        <div class="flex">
            <FormSelect v-model="form.dns" label="Which DNS do you want to use with the VPN" name="dns" class="w-full"
                        :options="dns_resolvers" required/>
        </div>

        <button class="btn btn-primary shadow-lg" @click="onSubmit">
            <i class="fas fa-plus"></i>
            Create
        </button>
    </div>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'
    import FormSelect from '@vue/components/Form/Select'
    import {mapGetters} from 'vuex'

    export default {
        components: {FormInput, FormSelect},
        data() {
            return {
                loading: false,
                teams: [],
                form: {
                    type: 'openvpn',
                    name: 'Test server',
                    team_id: null,
                    ip: null,
                    ssh_port: 22,
                    vpn_port: 1194,
                    vpn_protocol: 'udp',
                    dns: 'current'
                },
                label: {
                    name: 'Name',
                    team: 'Team',
                    ip: 'IP Address',
                    ssh_port: 'SSH port',
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
        mounted() {
            this.load()
        },
        methods: {
            load() {
                this.loading = true

                this.loadTeams()

                this.loading = false
            },
            async loadTeams() {
                try {
                    const teams = await this.$api.userProfileTeam.list()
                    this.teams = teams.map(team => {
                        return {
                            label: team.name,
                            value: team.id
                        }
                    })

                    this.form.team_id = this.user.team.id
                } catch (e) {
                    this.$handleError(e)
                }
            },
            async onSubmit() {
                const server = await this.$store.dispatch('servers/createServer', this.form)
            }
        },
        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            })
        }
    }
</script>
