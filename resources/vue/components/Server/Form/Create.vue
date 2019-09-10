<template>
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
                <FormSelect v-model="form.team_id" :label="label.team" name="team_id" class="ml-8 w-full" :options="teams" required/>
            </div>

            <div class="flex">
                <FormInput v-model="form.ip" :label="label.ip" name="ip" class="w-full mr-8" required/>
                <FormInput v-model="form.ssh_port" :label="label.ssh_port" name="ssh_port" required/>
            </div>

            <div class="flex">
                <FormSelect v-model="form.php_version" :label="label.php_version" name="php_version" class="w-full mr-8"
                            :options="php_versions" required/>
                <FormSelect v-model="form.database_type" :label="label.database_type" name="database_type"
                            class="w-full" :options="database_types" required/>
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
                    name: 'Test server',
                    team_id: null,
                    ip: null,
                    ssh_port: 22,
                    php_version: 73,
                    database_type: 'mysql'
                },
                label: {
                    name: 'Name',
                    team: 'Team',
                    ip: 'IP Address',
                    ssh_port: 'SSH port',
                    php_version: 'PHP version',
                    database_type: 'Database'
                },
                php_versions: [
                    {label: 'PHP 7.2', value: 72},
                    {label: 'PHP 7.3', value: 73}
                ],
                database_types: [
                    {label: 'MySQL 5.7', value: 'mysql'},
                    {label: 'MySQL 8', value: 'mysql8'},
                    {label: 'MariaDB', value: 'mariadb'},
                    {label: 'PostgreSQL', value: 'pgsql'},
                ],
            }
        },
        mounted() {
            this.loadTeams()
        },
        methods: {
            async loadTeams() {
                this.loading = true

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

                this.loading = false
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
