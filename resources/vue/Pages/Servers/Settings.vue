<template>
    <div class="w-full">
        <div class="container pl-10">
            <h1>Settings</h1>

            <SystemInformation :server="$parent.server" class="section--border-b"/>
        </div>

        <section class="section section--border-b">
            <div class="container pl-10">
                <div class="section-header">
                    Server's Public Key
                    <p>Typically, this key will automatically be added to GitHub or Bitbucket. However, if you need to
                        add
                        it to a service manually, you may copy it from here.</p>
                </div>
                <div class="section-body">
                <pre class="break-all whitespace-normal">
                    <Copy :text="server.public_key"/>
                </pre>
                </div>
            </div>
        </section>


        <section class="section section--border-b">
            <div class="container pl-10">
                <div class="section-header">
                    Server Metadata
                </div>
                <div class="section-body w-1/2">
                    <FormInput v-model="server.name" label="Server name" name="name" class="w-full mr-8" required/>

                    <button class="btn btn-primary shadow-lg" @click="onSubmit">
                        Save
                    </button>
                </div>
            </div>
        </section>
        <div class="container pl-10">
            <Destroy :server="server"/>
        </div>

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
