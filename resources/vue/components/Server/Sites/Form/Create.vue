<template>
    <div class="w-full">
        <div class="container pl-10">
            <section class="well well-lg">

                <Loader :loading="loading"/>
                <div class="section-header">
                    New site
                    <p>Think of sites as representing each "domain" on your server.</p>
                </div>
                <div class="section-body" v-if="$gate.allow('create', 'site', server)">
                    <div class="flex">
                        <FormInput v-model="form.domain" label="Domain" name="domain" class="w-full mr-8" required/>
                        <FormInput v-model="form.public_dir" label="Public dir" name="public_dir" class="w-full"
                                   required/>
                    </div>

                    <button class="btn btn-primary shadow-lg" @click="onSubmit">
                        Add site
                    </button>
                </div>
                <div v-else class="alert alert-primary">
                    <p>Upgrade your subscription to connect add more than one sites</p>
                </div>

            </section>
        </div>
    </div>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'

    export default {
        components: {FormInput},
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                form: {
                    domain: '',
                    public_dir: '/public'
                }
            }
        },
        methods: {
            created(site) {
                this.$emit('created', site)
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
