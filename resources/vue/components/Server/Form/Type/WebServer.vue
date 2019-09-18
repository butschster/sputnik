<template>
    <div>
        <div class="flex">
            <FormSelect v-model="form.php_version"
                        label="Which PHP version do you want to install"
                        name="php_version"
                        class="w-full mr-8"
                        :options="php_versions"
                        required/>

            <FormSelect v-model="form.database_type"
                        label="Which database type do you want to install"
                        name="database_type"
                        class="w-full mr-8"
                        :options="database_types"
                        required/>

            <FormSelect v-model="form.webserver_type"
                        label="Which web server do you want to install"
                        name="webserver_type"
                        class="w-full"
                        :options="webserver_types"
                        required/>
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

    export default {
        components: {FormInput, FormSelect},
        data() {
            return {
                form: {
                    php_version: null,
                    database_type: null,
                    webserver_type: null,
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
                this.$emit('loading', true)

                this.loadPHPVersions()
                this.loadDatabaseTypes()
                this.loadWebserverTypes()

                this.$emit('loading', false)
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
            async onSubmit() {
                this.$emit('submit', this.form)
            }
        }
    }
</script>
