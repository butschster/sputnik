<template>
    <div v-if="$gate.allow('destroy', 'site', site)">
        <Loader :loading="loading" />
        <section class="section flex items-center">
            <div class="flex-1">
                <div class="section-header">
                    {{ $t('site.destroy.title') }}
                    <p class="text-gray-600">{{ $t('site.destroy.description') }}</p>
                </div>
            </div>
            <div>
                <button class="btn btn-danger-outline" @click="onDestroy">
                    {{ $t('site.destroy.button.destroy') }}
                </button>

                <Modal name="destroySite">
                    <div class="modal__top">
                        {{ $t('site.destroy.modal.title') }}
                    </div>
                    <div class="modal__content">
                        <p class="mb-3">{{ $t('site.destroy.modal.description') }}</p>

                        <button class="btn btn-danger-outline btn-block" @click="destroy">
                            {{ $t('site.destroy.modal.button.destroy') }}
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

                    this.$notify.success(
                        this.$t('site.destroy.message.successful')
                    )
                    this.$modal.hide('destroySite')

                    this.$router.replace(
                        this.$link.server(this.site.server_id)
                    )
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
    }
</script>
