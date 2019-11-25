<template>
    <div>
        <Loader :loading="loading"/>
        <h2>{{ $t('site.environment.title') }}</h2>
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
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1568/1568465.svg" alt="" width="150px">
            <h3 class="mb-0">{{ $t('site.environment.message.empty') }}</h3>
        </div>

        <section class="section section--border-b well well-lg">
            <Loader :loading="createFormLoading"/>
            <div class="section-header">
                {{ $t('site.environment.form.create.title') }}
            </div>
            <div class="flex">
                <FormInput v-model="createForm.key"
                           :label="$t('site.environment.form.create.key')"
                           name="key"
                           class="flex-1 mr-8" required/>

                <FormInput v-model="createForm.value"
                           :label="$t('site.environment.form.create.value')"
                           name="value"
                           class="mr-8"
                           required/>

                <div class="form-group mb-0">
                    <button class="btn btn-primary" @click="onSubmit">
                        {{ $t('site.environment.form.create.button') }}
                    </button>
                </div>
            </div>
        </section>

        <div class="section well well-lg">
            <Loader :loading="uploadLoading"/>
            <div class="section-header">
                {{ $t('site.environment.form.upload.title') }}
                <p>{{ $t('site.environment.form.upload.description') }}</p>
            </div>

            <Textarea v-model="uploadForm.variables"
                      :label="$t('site.environment.form.upload.textarea')"
                      name="variables"/>

            <button class="btn btn-primary" @click="onUploadFile">
                {{ $t('site.environment.form.upload.button') }}
            </button>
        </div>
    </div>
</template>

<script>
    import FormInput from '@vue/components/Form/Input.vue'
    import Textarea from "@vue/components/Form/Textarea"

    export default {
        components: {Textarea, FormInput},
        data() {
            return {
                loading: false,
                variables: [],
                uploadLoading: false,
                createFormLoading: false,
                createForm: {
                    key: '',
                    value: '',
                },
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
            async onSubmit() {
                this.createFormLoading = true

                try {
                    this.variables = await this.$api.serverSiteEnvironment.update(this.site.id, this.createForm)
                    this.resetVariables()
                    this.$notify.success('Variables stored successfully.')
                } catch (e) {
                    this.$handleError(e)
                }

                this.createFormLoading = false
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
                this.createForm = {
                    key: '',
                    value: '',
                }
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
