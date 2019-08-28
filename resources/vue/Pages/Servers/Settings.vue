<template>
    <div>
        <section class="section">
            <div class="section-header">
                Server's Public Key
                <p>Typically, this key will automatically be added to GitHub or Bitbucket. However, if you need to add
                    it to a service manually, you may copy it from here.</p>
            </div>
            <div class="section-body">
                <pre class="break-all whitespace-normal">
                    {{ server.public_key }}
                </pre>
            </div>
        </section>

        <section class="section mt-10 pt-10">
            <div class="section-header">
                Server Metadata
            </div>
            <div class="section-body w-1/2">
                <FormInput v-model="server.name" label="Server name" name="name" class="w-full mr-8" required/>

                <button class="btn btn-blue shadow-lg" @click="onSubmit">
                    Save
                </button>
            </div>
        </section>
    </div>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'

    export default {
        components: {FormInput},
        data() {
            return {
                loading: false
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    await this.$api('v1.server.update', {server: this.server.id}).request({name: this.server.name})

                    this.$notify({
                        text: 'Server settings saved',
                        type: 'success'
                    });

                } catch (e) {
                    console.error(e)
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