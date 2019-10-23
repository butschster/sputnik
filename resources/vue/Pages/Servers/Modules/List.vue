<template>
    <div>
        <Loader :loading="loading"/>
        <h1>{{ $t('server.modules.title') }}</h1>

        <h3>{{ $t('server.modules.installed.title') }}</h3>

        <div>
            <ModuleInformation v-for="module in installedModules" :module="module" />
        </div>
        <div class="section well well-lg">
            <ModuleForm
                    :module="module"
                    :key="module.key"
                    @onChange="updateModuleData"
                    v-for="module in modulesWithForm"
            />

            <Modules :except="installedModulesKeys" :default-modules="[]" @onSelect="onModuleSelect"/>

            <button class="btn btn-primary shadow-lg" @click="onSubmit" v-if="hasSelectedModules">
                {{ $t('server.modules.button.install') }}
            </button>
        </div>
    </div>
</template>

<script>
    import ModuleForm from "@vue/components/Server/Form/partials/ModuleForm"
    import Modules from "@vue/components/Server/Form/partials/Modules"
    import ModuleInformation from "@vue/components/Server/Modules/Information"

    export default {
        components: {Modules, ModuleForm, ModuleInformation},
        data() {
            return {
                loading: false,
                modulesData: {},
                selectedModules: []
            }
        },
        methods: {
            updateModuleData(module, data) {
                this.modulesData[module] = data
            },
            onModuleSelect(modules) {
                this.selectedModules = modules
            },
            async onSubmit() {
                this.loading = true

                try {
                    await this.$api.serverModules.install(
                        this.$parent.server.id,
                        {modules: this.form}
                    )

                    this.$notify.success(
                        this.$t('server.modules.message.installed')
                    )
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        },
        computed: {
            installedModulesKeys() {
                return this.$parent.server.modules.map(m => m.key)
            },
            installedModules() {
                return this.$parent.server.modules.filter(m => m.status == 'installed')
            },
            form() {
                return this.selectedModules.map(m => {
                    return {key: m.key, ...this.modulesData[m.key]}
                })
            },
            hasSelectedModules() {
                return _.size(this.selectedModules) > 0
            },
            modulesWithForm() {
                return this.selectedModules.filter(m => m.fields.length > 0)
            }
        }
    }
</script>
