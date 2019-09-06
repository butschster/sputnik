<template>
    <div>
        <Loader :loading="loading"/>
        <section class="section flex items-center">
            <div class="flex-1">
                <div class="section-header">
                    Destroy Server
                    <p class="text-gray-600">This is irreversible. We will remove your Server record from your account,
                        but all your setting will keep on your physical server.</p>
                </div>
            </div>
            <div>
                <button class="btn btn-danger" @click="onDestroy">
                    Destroy
                </button>

                <Modal name="destroyServer">
                    <div class="modal__top">
                        Are you absolutely sure?
                    </div>
                    <div class="modal__content">
                        <p class="mb-3">This action cannot be undone. This will permanently delete your server.</p>

                        <button class="btn btn-danger btn-block" @click="destroy">
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
            server: Object
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            onDestroy() {
                this.$modal.show('destroyServer')
            },
            async destroy() {
                this.loading = true

                try {
                    await this.$api.server.remove(this.server.id)

                    this.$notify.success('Server successfully destroyed')

                    this.$router.replace(
                        this.$link.servers()
                    )

                    this.$modal.hide('destroyServer')
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        }
    }
</script>