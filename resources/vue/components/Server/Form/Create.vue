<template>
    <div class="section well well-lg">
        <div class="section-header">
            Connect server

            <p>You can connect any server with public IP address and opened ssh port. Your server must run a fresh
                installation of Ubuntu 18.04 x64 and must have a root user.</p>
        </div>

        <div class="section-body" v-if="$gate.allow('create', 'server')">
            <Loader :loading="loading"/>

            <FormSelect v-model="form.type"
                        label="Server type"
                        :options="types"
                        required/>

            <div class="flex">
                <FormInput v-model="form.name"
                           label="Come up with server name"
                           name="name"
                           class="w-full"
                           required
                           autofocus/>

                <FormSelect v-if="teams.length > 1"
                            v-model="form.team_id"
                            label="Select team for your server"
                            name="team_id"
                            class="ml-8 w-full"
                            :options="teams" required/>
            </div>

            <div class="flex">
                <FormInput v-model="form.ip"
                           label="Specify IP address of your server"
                           name="ip"
                           class="w-full mr-8"
                           required/>

                <FormInput v-model="form.ssh_port" label="Set SSH port"
                           name="ssh_port"
                           required/>
            </div>

            <Component :is="form.type" @submit="onSubmit"/>

        </div>
        <div v-else class="alert alert-primary">
            <p>Upgrade your subscription to connect more servers</p>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import FormInput from '@vue/components/Form/Input'
    import FormSelect from '@vue/components/Form/Select'

    import webserver from "@vue/components/Server/Form/Type/WebServer"
    import openvpn from "@vue/components/Server/Form/Type/OpenVPN"

    export default {
        components: {FormSelect, FormInput, webserver, openvpn},
        data() {
            return {
                loading: false,
                form: {
                    type: null,
                    name: 'Test server',
                    team_id: null,
                    ip: null,
                    ssh_port: 22,
                },
                teams: [],
                types: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            load() {
                this.loading = true

                this.loadTypes()
                this.loadTeams()

                this.loading = false
            },
            async loadTypes() {
                try {
                    this.types = await this.$api.serverDictionaries.types()
                    this.form.type = 'webserver'
                } catch (e) {
                    this.$handleError(e)
                }
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
            async onSubmit(data) {
                this.loading = true

                try {
                    await this.$store.dispatch('servers/createServer', Object.assign({}, this.form, data))
                } catch (e) {
                }

                this.loading = false
            }
        },
        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            })
        }
    }
</script>
