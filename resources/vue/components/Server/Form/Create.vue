/<template>
    <div class="section well well-lg">
        <div class="section-header">
            {{ title }}

            <p>You can connect any server with public IP address and opened ssh port. Your server must run a fresh
                installation of Ubuntu 18.04 x64 and must have a root user.</p>
        </div>

        <div class="card-body" v-if="$gate.allow('create', 'server')">
            <Loader :loading="loading" />
            <div class="flex">
                <FormInput v-model="form.name" :label="label.name" name="name" class="w-full" required autofocus/>
                <FormSelect v-if="teams.length > 1" v-model="form.team_id" :label="label.team" name="team_id" class="ml-8 w-full" :options="teams" required/>
            </div>

            <div class="flex">
                <FormInput v-model="form.ip" :label="label.ip" name="ip" class="w-full mr-8" required/>
                <FormInput v-model="form.ssh_port" :label="label.ssh_port" name="ssh_port" required/>
            </div>

            <div class="flex">
                <FormSelect v-model="form.php_version" :label="label.php_version" name="php_version" class="w-full mr-8"
                            :options="php_versions" required/>
                <FormSelect v-model="form.database_type" :label="label.database_type" name="database_type"
                            class="w-full mr-8" :options="database_types" required/>
                <FormSelect v-model="form.webserver_type" :label="label.webserver_type" name="webserver_type"
                            class="w-full" :options="webserver_types" required/>
            </div>

            <button class="btn btn-primary shadow-lg" @click="onSubmit">
                <i class="fas fa-plus"></i>
                Create
            </button>
        </div>
        <div v-else class="alert alert-primary">
            <p>Upgrade your subscription to connect more servers</p>
        </div>
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
                    type: 'webserver',
                    name: 'Test server',
                    team_id: null,
                    ip: null,
                    ssh_port: 22,
                    php_version: null,
                    database_type: null,
                    webserver_type: null,
                },
                label: {
                    name: 'Name',
                    team: 'Team',
                    ip: 'IP Address',
                    ssh_port: 'SSH port',
                    php_version: 'PHP version',
                    database_type: 'Database',
                    webserver_type: 'Webserver',
                },
                php_versions: [],
                database_types: [],
                webserver_types: [],
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            load() {
                this.loading = true

                this.loadTeams()
                this.loadPHPVersions()
                this.loadDatabaseTypes()
                this.loadWebserverTypes()

                this.loading = false
            },
            async loadPHPVersions() {
                try {
                    this.php_versions = await this.$api.serverDictionaries.phpVersions()
                } catch (e) {
                    this.$handleError(e)
                }
            },
            async loadDatabaseTypes() {
                try {
                    this.database_types = await this.$api.serverDictionaries.databaseTypes()
                } catch (e) {
                    this.$handleError(e)
                }
            },
            async loadWebserverTypes() {
                try {
                    this.webserver_types = await this.$api.serverDictionaries.webserverTypes()
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
            async onSubmit() {
                const server = await this.$store.dispatch('servers/createServer', this.form)
            }
        },
        computed: {
            ...mapGetters('servers', {
                hasServers: 'hasServers',
            }),
            ...mapGetters('auth', {
                user: 'getUser',
            }),
            title() {
                if (this.hasServers) {
                    return 'Connect another one'
                }

                return 'Connect your first server'
            }
        }
    }
</script>
