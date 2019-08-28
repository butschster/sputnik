<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            New site
            <p>Think of sites as representing each "domain" on your server.</p>
        </div>
        <div class="section-body" v-if="$gate.allow('create', 'site', server)">
            <div class="flex">
                <FormInput v-model="form.domain" label="Domain" name="domain" class="w-full mr-8" required/>
                <FormInput v-model="form.public_dir" label="Public dir" name="public_dir" class="w-full" required/>
            </div>

            <button class="btn btn-blue shadow-lg" @click="onSubmit">
                Add site
            </button>
        </div>
        <div v-else class="alert alert-primary">
            <p>Upgrade your subscription to connect add more than one sites</p>
        </div>
    </section>
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
                    const response = await this.$api('v1.server.site.store', {server: this.$route.params.id})
                        .request(this.form)
                    this.created(response.data.data)
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        }
    }
</script>