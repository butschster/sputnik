<template>
    <div>
        <Loader :loading="loading"/>
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
    import {Module} from "@js/models/Module";

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
                this.selected = this.selected.filter(m => !m.is(module))
                this.selected.filter(m => m.hasDependencies)
                    .forEach(md => {
                        if (this.selected.filter(m => m.checkDependencies(md)).length === 0) {
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

                if (module.hasDependencies) {
                    if (this.selected.filter(m => m.checkDependencies(module)).length === 0) {

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
                    const modules = await this.$api.serverModules.list()

                    this.modules = Object.values(modules).map(m => new Module(m))
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
            installableModules() {
                return this.modules.filter(m => m.isInstallable)
            },
            availableModules() {
                return this.installableModules.filter(m => {
                    return this.except.indexOf(m.key) == -1
                }).filter(m => {
                    return this.selected.indexOf(m) == -1
                }).filter(md => {
                    return this.selected
                        .filter(m => m.hasConflictsWithModules)
                        .filter(m => m.checkConflicts(md))
                        .length === 0
                })
            }
        }
    }
</script>
