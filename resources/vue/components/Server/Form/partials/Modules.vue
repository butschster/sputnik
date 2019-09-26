<template>
    <div>
        <Loader :loading="loading" />
        <div class="section" v-if="hasModules">
            <div class="section-header">
                {{ $t('server.modules.available.title') }}
                <p>{{ $t('server.modules.available.description') }}</p>
            </div>
            <div class="mb-4">
                <button v-for="module in availableModules" :key="module.key" class="btn btn-sm btn-primary mr-2 mb-2"
                        @click="select(module.key)">
                    {{ module.title }}
                </button>
            </div>
        </div>
        <div class="section" v-if="hasSelected">
            <div class="section-header">
                {{ $t('server.modules.selected.title') }}
                <p>{{ $t('server.modules.selected.description') }}</p>
            </div>
            <div class="mb-4">
                <button v-for="module in selected"
                        class="btn btn-sm btn-danger mr-2 mb-2"
                        @click="remove(module)">
                    {{ module.title }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Str from '@js/helpers/str'

    export default {
        props: {
            value: Array,
            except: {
                type: Array,
                default() {
                    return []
                }
            },
            defaultModules: {
                type: Array,
                default() {
                    return ['base_settings', 'ufw']
                }
            }
        },
        data() {
            return {
                modules: [],
                selected: [],
                loading: false
            }
        },
        mounted() {
            this.loadModules()
        },
        watch: {
            selected() {
                this.updateFormData()
            }
        },
        methods: {
            remove(module) {
                this.selected = this.selected.filter(m => m.key != module.key)
                this.selected.filter(m => m.dependencies.length > 0).forEach(md => {
                    if (this.selected.filter(m => Str(m.key).is(md.dependencies)).length === 0) {
                        this.remove(md)
                    }
                })
            },
            select(key) {
                const module = _.find(this.availableModules, m => m.key === key)

                if (!module) {
                    console.error('Module not found.', key)
                    return
                }

                if (module.dependencies.length > 0) {
                    if (this.selected.filter(m => Str(m.key).is(module.dependencies)).length === 0) {

                        console.error('Module does\'t have required dependencies.', module.dependencies)
                        return
                    }
                }

                this.selected.push(module)
            },
            loaded() {
                this.defaultModules.forEach(key => this.select(key))
            },
            async loadModules() {
                this.loading = true

                try {
                    this.modules = await this.$api.serverModules.list()
                    this.loaded()
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
            updateFormData() {
                this.$emit('onSelect', this.selected)
            }
        },
        computed: {
            hasSelected() {
                return this.selected.length > 0
            },
            hasModules() {
                return this.availableModules.length > 0
            },
            availableModules() {
                return _.filter(this.modules, m => {
                    return this.except.indexOf(m.key) == -1
                }).filter(m => {
                    return this.selected.indexOf(m) == -1
                })
            }
        }
    }
</script>
