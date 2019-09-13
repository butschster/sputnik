<template>
    <div v-if="$gate.allow('destroy', 'site', site)">
        <Loader :loading="loading" />
        <section class="section flex items-center">
            <div class="flex-1">
                <div class="section-header">
                    Destroy Site
                    <p class="text-gray-600">This is irreversible. We will remove your site folder and web server configuration from your server.</p>
                </div>
            </div>
            <div>
                <button class="btn btn-danger-outline" @click="onDestroy">
                    Destroy
                </button>

                <Modal name="destroySite">
                    <div class="modal__top">
                        Are you absolutely sure?
                    </div>
                    <div class="modal__content">
                        <p class="mb-3">This action cannot be undone. This will permanently delete your site.</p>

                        <button class="btn btn-danger-outline btn-block" @click="destroy">
                            I understand the consequences, continue
                        </button>
                    </div>
                </Modal>
            </div>
        </section>
    </div>
</template>

<script>
    import Modal from "@vue/components/UI/Modal"
    export default {
        components: {Modal},
        props: {
            site: Object
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            onDestroy() {
                this.$modal.show('destroySite')
            },
            async destroy() {
                this.loading = true

                try {
                    await this.$api.serverSites.remove(this.site.id)

                    this.$notify.success('Site successfully destroyed')

                    this.$router.replace(
                        this.$link.server(this.site.server_id)
                    )
                    this.$modal.hide('destroySite')
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
    }
</script>
