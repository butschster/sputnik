<template>
    <div>
        <div class="section" v-if="hasSelected">
            <div class="section-header">
                Устанавливаемые модули
            </div>
           <div class="flex">
               <Module v-for="module in selected" :key="module.key" :module="module" class="mb-2 mr-2" @onRemove="remove"/>
           </div>
        </div>
        <div class="section">
            <div class="section-header">
                Доступные модули
                <p></p>
                <p>Вы можете выбрать ПО, которое будет установлено на вашем сервере. </p>
            </div>
            <div class="p-5 bg-gray-100 mb-4">
                <button v-for="module in availableModules" :key="module.key" class="btn btn-sm btn-primary mr-2 mb-2"
                        @click="select(module.key)">
                    {{ module.title }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Str from '@js/helpers/str'

    import Module from "./Module"

    export default {
        components: {Module},
        props: {
            value: Array
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
        methods: {
            remove(module) {
                this.selected = this.selected.filter(m => m.key != module.key)
                this.selected.filter(m => m.dependencies.length > 0).forEach(md => {
                    if (this.selected.filter(m => Str(m.key).is(md.dependencies)).length === 0) {
                        this.remove(md)
                    }
                })
                this.updateFormData()
            },
            select(key) {
                const module = _.find(this.modules, m => m.key === key)

                if (module.dependencies.length > 0) {
                    if (this.selected.filter(m => Str(m.key).is(module.dependencies)).length === 0) {

                        console.log('Module does\'t have required dependencies.', module.dependencies)
                        return
                    }
                }

                this.selected.push(module)

                this.updateFormData()
            },
            async loadModules() {
                this.loading = true

                try {
                    this.modules = await this.$api.serverModules.list()
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
            updateFormData() {
                const data = _.keyBy(this.selected.map(m => {
                    return {key: m.key, data: {}}
                }), 'key')

                this.$emit('input', data)
            }
        },
        computed: {
            hasSelected() {
                return this.selected.length > 0
            },
            availableModules() {
                return _.filter(this.modules, m => {
                    return this.selected.indexOf(m) == -1
                })
            }
        }
    }
</script>