<template>
    <div>
        <Loader :loading="loading"/>
        <section class="section flex items-center">
            <div class="flex-1 mr-10">
                <div class="section-header">
                    {{ $t('server.destroy.title') }}
                    <p class="text-gray-600">
                        {{ $t('server.destroy.description') }}</p>
                </div>
            </div>
            <div>
                <button class="btn btn-danger-outline" @click="onDestroy">
                    {{ $t('server.destroy.buttons.destroy') }}
                </button>

                <Modal name="destroyServer">
                    <div class="modal__top">
                        {{ $t('server.destroy.modal.title') }}
                    </div>
                    <div class="modal__content">
                        <button class="btn btn-danger-outline btn-block" @click="destroy">
                            {{ $t('server.destroy.modal.button') }}
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
