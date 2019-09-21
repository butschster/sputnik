<template>
    <div class="w-full">
        <div class="container px-10">
            <div class="section well well-lg">
                <div class="section-header">
                    {{ $t('server.form.create.title') }}

                    <p>{{ $t('server.form.create.description') }}</p>
                </div>

                <div class="section-body" v-if="$gate.allow('create', 'server')">
                    <Loader :loading="loading"/>

                    <FormSelect v-model="form.type"
                                :label="$t('server.form.create.label.type')"
                                :options="types"
                                required/>

                    <div class="flex">
                        <FormInput v-model="form.name"
                                   :label="$t('server.form.create.label.name')"
                                   name="name"
                                   class="w-full"
                                   required
                                   autofocus/>

                        <FormSelect v-if="teams.length > 1"
                                    v-model="form.team_id"
                                    :label="$t('server.form.create.label.team')"
                                    name="team_id"
                                    class="ml-8 w-full"
                                    :options="teams" required/>
                    </div>

                    <div class="flex">
                        <FormInput v-model="form.ip"
                                   :label="$t('server.form.create.label.ip')"
                                   name="ip"
                                   class="w-full mr-8"
                                   required/>

                        <FormInput v-model="form.ssh_port"
                                   :label="$t('server.form.create.label.ssh_port')"
                                   name="ssh_port"
                                   required/>
                    </div>

                    <Component :is="form.type" @submit="onSubmit"/>

                </div>
                <div v-else class="alert alert-primary">
                    <p>{{ $t('server.form.create.message.upgrade_subscription') }}</p>
                </div>
            </div>
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
                    name: null,
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
                    const server = await this.$store.dispatch('servers/createServer', Object.assign({}, this.form, data))

                    this.$notify.success(
                        this.$t('server.form.create.message.created')
                    )

                    this.$router.push(
                        this.$link.server(server)
                    )
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
