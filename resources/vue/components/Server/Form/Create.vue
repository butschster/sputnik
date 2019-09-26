<template>
    <div class="section well well-lg">
        <div class="section-header">
            {{ $t('server.form.create.title') }}

            <p>{{ $t('server.form.create.description') }}</p>
        </div>

        <div class="section-body" v-if="$gate.allow('create', 'server')">
            <Loader :loading="loading"/>

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

            <ModuleForm
                :module="module"
                :key="module.key"
                @onChange="updateModuleData"
                v-for="module in modulesWithForm"
            />

            <Modules @onSelect="onModuleSelect"/>

            <button class="btn btn-primary shadow-lg" @click="onSubmit">
                <i class="fas fa-plus"></i>
                {{ $t('server.form.create.button.create') }}
            </button>
        </div>
        <div v-else class="alert alert-primary">
            <p>{{ $t('server.form.create.message.upgrade_subscription') }}</p>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import Modules from "./partials/Modules"
    import ModuleForm from "./partials/ModuleForm"
    import FormInput from '@vue/components/Form/Input'
    import FormSelect from '@vue/components/Form/Select'

    export default {
        components: {ModuleForm, Modules, FormSelect, FormInput},
        data() {
            return {
                loading: false,
                form: {
                    name: null,
                    team_id: null,
                    ip: null,
                    ssh_port: 22,
                },
                modulesData: {},
                selectedModules: [],
                teams: [],
                types: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            updateModuleData(module, data) {
                this.modulesData[module] = data
            },
            onModuleSelect(modules) {
                this.selectedModules = modules
            },
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
                this.loading = true

                try {
                    const modules = this.selectedModules.map(m => {return {key: m.key, ...this.modulesData[m.key]}})

                    const server = await this.$store.dispatch(
                        'servers/createServer',
                        Object.assign(
                            {},
                            this.form,
                            {
                                modules: _.keyBy(modules, m => m.key)
                            }
                        )
                    )

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
            }),
            modulesWithForm() {
                return this.selectedModules.filter(m => m.fields.length > 0)
            }
        }
    }
</script>
