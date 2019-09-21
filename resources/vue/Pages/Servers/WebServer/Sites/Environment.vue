<template>
    <div class="w-full">
        <div class="container px-10">
            <Loader :loading="loading"/>
            <h2>Environment variables</h2>

            <div v-if="hasVariables">

                <template v-for="(vars, group) in groupedVariables">
                    <h4>{{ group }}</h4>

                    <table class="table mb-10">
                        <col width="250px">
                        <col>
                        <col width="100px">
                        <tbody>
                        <tr v-for="(value, key) in vars">
                            <th>{{ key }}</th>
                            <td>
                                <Copy :text="value" v-if="canBeCopiedValue(value)"/>
                                <span v-else>{{ value }}</span>
                            </td>
                            <td class="text-right">
                                <button class="btn btn-danger btn-circle btn-sm" @click="onRemove(key)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </template>
            </div>

            <div v-else class="well well-lg text-center">
                <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1568/1568465.svg" alt=""
                     width="150px">
                <h3 class="mb-0">Looks like you don't have any env variables yet</h3>
            </div>


            <div class="section well well-lg">

                <Loader :loading="uploadLoading"/>
                <div class="section-header">
                    Load from .env string
                    <p>Paste contents from .env file</p>
                </div>
                <Textarea v-model="uploadForm.variables" label="String with variables" name="variables"/>
                <button class="btn btn-primary" @click="onUploadFile">Upload</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Textarea from "@vue/components/Form/Textarea"

    export default {
        components: {Textarea},
        data() {
            return {
                loading: false,
                variables: [],
                uploadLoading: false,
                uploadForm: {
                    variables: null
                }
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.variables = await this.$api.serverSiteEnvironment.list(this.site.id)

                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async onRemove(key) {
                this.loading = true

                try {
                    this.variables = await this.$api.serverSiteEnvironment.remove(this.site.id, key)
                    this.resetVariables()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async onUploadFile() {
                this.uploadLoading = true

                try {
                    this.variables = await this.$api.serverSiteEnvironment.upload(this.site.id, this.uploadForm.variables)
                    this.resetVariables()
                    this.$notify.success('Variables stored successfully.')
                } catch (e) {
                    this.$handleError(e)
                }

                this.uploadLoading = false
            },
            resetVariables() {
                this.uploadForm.variables = null
            },
            canBeCopiedValue(value) {
                if (value === '**********') {
                    return false
                }

                if (value === 'null') {
                    return false
                }

                return value.length > 0
            }
        },
        computed: {
            site() {
                return this.$parent.site
            },
            hasVariables() {
                return Object.keys(this.variables).length > 0
            },
            groupedVariables() {
                const keys = Object.keys(this.variables)
                const groupedKeys = _.groupBy(keys, (key) => {
                    return key.split("_", 1)
                })

                let groupedVariables = {}

                _.forEach(groupedKeys, (variables, group) => {
                    if (typeof groupedVariables[group] == 'undefined') {
                        groupedVariables[group] = {}
                    }

                    variables.forEach(key => {
                        groupedVariables[group][key] = this.variables[key]
                    })
                })

                return groupedVariables
            }
        }
    }
</script>
