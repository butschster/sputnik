<template>
    <section class="well well-lg">
        <Loader :loading="loading"/>
        <div class="section-header">
            {{ $t('site.repository.title') }}
        </div>
        <div class="section-body">
            <div>
                <h4>{{ $t('site.repository.form.label.source_provider') }}</h4>

                <div class="flex">
                    <FormRadio v-model="form.repository_provider"
                               label="Custom"
                               class="mr-4"
                               key="custom"
                               name="repository_provider"
                               :value="null"
                               required />

                    <FormRadio v-model="form.repository_provider"
                               v-for="provider in providers"
                               :label="provider.name"
                               :key="provider.type"
                               class="mr-4"
                               :value="provider.type"
                               name="repository_provider"
                               required />
                </div>

                <span class="invalid-feedback" role="alert" v-if="httpErrors.has('repository_provider')">
                    <strong>{{ httpErrors.first('repository_provider') }}</strong>
                </span>
            </div>

            <div class="flex">
                <FormInput v-model="form.repository"
                           :label="$t('site.repository.form.label.repository')"
                           name="repository"
                           class="w-full mr-8"
                           required />
                <FormInput v-model="form.repository_branch"
                           :label="$t('site.repository.form.label.branch')"
                           name="repository_branch"
                           class="w-64"
                           required />
            </div>

            <button class="btn btn-primary shadow-lg mt-5" @click="onSubmit">
                {{ $t('site.repository.form.button.save') }}
            </button>
        </div>
    </section>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'
    import FormRadio from '@vue/components/Form/Radio'

    export default {
        components: {FormInput, FormRadio},
        props: {
            site: Object
        },
        data() {
            return {
                loading: false,
                providers: [],
                form: {
                    repository_provider: null,
                    repository: null,
                    repository_branch: null
                }
            }
        },
        created() {
            this.loadSourceProviders()
            this.updateFormData()
        },
        watch: {
            site: {
                handler(site) {
                    this.updateFormData()
                },
                deep: true
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    await this.$api.serverSiteRepository.update(this.site.id, this.form)
                    this.$bus.$emit('site.updated')
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async loadSourceProviders() {
                this.loading = true

                try {
                    this.providers = await this.$api.userProfile.sourceProviders()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            updateFormData() {
                this.form.repository_provider = this.site.repository.provider
                this.form.repository = this.site.repository.name
                this.form.repository_branch = this.site.repository.branch
            }
        }
    }
</script>