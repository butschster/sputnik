<template>
    <div>
        <h1>{{ $t('server.settings.title') }}</h1>

        <SystemInformation :server="$parent.server" class="section--border-b"/>

        <section class="section section--border-b">
            <div class="section-header">
                {{ $t('server.settings.public_key.title') }}
                <p>
                    {{ $t('server.settings.public_key.description') }}</p>
            </div>
            <div class="section-body">
                <pre class="break-all whitespace-normal">
                    <Copy :text="server.public_key" />
                </pre>
            </div>
        </section>

        <section class="section section--border-b">
            <div class="section-header">
                {{ $t('server.settings.metadata.title') }}
            </div>
            <div class="section-body w-1/2">
                <FormInput v-model="server.name"
                           :label="$t('server.settings.metadata.form.name')"
                           name="name"
                           class="w-full mr-8"
                           required/>

                <button class="btn btn-primary shadow-lg" @click="onSubmit">
                    {{ $t('server.settings.metadata.buttons.save') }}
                </button>
            </div>
        </section>

        <Destroy :server="server" />
    </div>
</template>

<script>
    import SystemInformation from "@vue/components/Server/partials/SystemInformation"
    import FormInput from '@vue/components/Form/Input'
    import Destroy from "@vue/components/Server/partials/Destroy"

    export default {
        components: {SystemInformation, FormInput, Destroy},
        data() {
            return {
                loading: false
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    await this.$api.server.update(this.server.id, {name: this.server.name})

                    this.$notify.success('Server settings saved')

                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
        computed: {
            server() {
                return this.$parent.server
            }
        }
    }
</script>
