<template>
    <section class="well well-lg">
        <Loader :loading="loading"/>
        <div class="section-header">
            {{ $t('site.form.create.title') }}
            <p>{{ $t('site.form.create.description') }}</p>
        </div>
        <div class="section-body" v-if="$gate.allow('create', 'site', server)">
            <FormSelect v-model="form.webserver"
                        :label="$t('site.form.create.label.web_server')"
                        name="web_server"
                        class="w-full"
                        :options="web_servers"
                        required
                        autofocus />

            <FormCheckbox v-model="form.is_proxy"
                          :label="$t('site.form.create.label.is_proxy')"
                          name="is_proxy" />

            <FormSelect v-model="form.processor"
                        :label="$t('site.form.create.label.processor')"
                        name="processor"
                        class="w-full"
                        :options="processors"
                        required v-if="!form.is_proxy" />

            <FormInput v-model="form.proxy_address" :label="$t('site.form.create.label.proxy_address')" name="proxy_address" class="w-full" required v-if="form.is_proxy"/>

            <div class="flex">
                <FormInput v-model="form.domain" :label="$t('site.form.create.label.domain')" name="domain" class="w-full mr-8" required/>
                <FormInput v-model="form.public_dir" :label="$t('site.form.create.label.public_dir')" name="public_dir" class="w-full" required/>
            </div>

            <button class="btn btn-primary shadow-lg" @click="onSubmit">
                {{ $t('site.form.create.button.create') }}
            </button>
        </div>
        <div v-else class="alert alert-primary">
            <p>{{ $t('site.form.create.message.upgrade_subscription') }}</p>
        </div>
    </section>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'
    import FormSelect from '@vue/components/Form/Select'
    import FormCheckbox from '@vue/components/Form/Checkbox'

    export default {
        components: {FormInput, FormSelect, FormCheckbox},
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                processors: [],
                web_servers: [],
                form: {
                    is_proxy: false,
                    webserver: null,
                    processor: null,
                    domain: null,
                    proxy_address: null,
                    public_dir: '/public'
                }
            }
        },
        mounted() {
            this.loadProcessors()
            this.loadWebServers()
        },
        methods: {
            created(site) {
                this.$emit('created', site)
            },
            async loadProcessors() {
                try {
                    this.processors = await this.$api.serverSites.processors(this.$route.params.id)
                } catch (e) {
                    this.$handleError(e)
                }
            },
            async loadWebServers() {
                try {
                    this.web_servers = await this.$api.serverSites.webServers(this.$route.params.id)
                } catch (e) {
                    this.$handleError(e)
                }
            },

            async onSubmit() {
                this.loading = true

                try {
                    const site = await this.$api.serverSites.store(this.$route.params.id, this.form)
                    this.created(site)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        }
    }
</script>
