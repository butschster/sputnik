<template>
    <portal to="modals">
        <div class="modal" v-if="visible" :id="`modal-${name}`">
            <div class="modal-wrapper" ref="modal">
                <button v-if="close_button" class="modal__close" @click="closeModal">
                    <i class="fas fa-times"></i>
                </button>

                <slot></slot>
            </div>
        </div>
    </portal>
</template>

<script>
    export default {
        props: {
            name: String,
            close_button: {
                type: Boolean,
                default() {
                    return true
                }
            },
            close_outside: {
                type: Boolean,
                default() {
                    return true
                }
            },
        },
        data() {
            return {
                visible: false
            }
        },
        mounted() {
            if (this.close_outside) {
                this.registerOutsideClose()
            }

            this.registerEscapeClose()

            this.$modal.event
                .$on('show', (modal) => {
                    if (this.name == modal) {
                        this.visible = true
                    }
                })
                .$on('close', (modal) => {
                    if (this.name == modal) {
                        this.visible = false
                    }
                })
                .$on('close-all', (modal) => {
                    this.visible = false
                })
        },
        watch: {
            visible(state) {
                this.$emit('visible', state)
            }
        },
        methods: {
            registerEscapeClose() {
                const escapeHandler = (e) => {
                    if (e.key === 'Escape' && this.visible) {
                        this.closeModal()
                    }
                }

                document.addEventListener('keydown', escapeHandler)
                this.$once('hook:destroyed', () => {
                    document.removeEventListener('keydown', escapeHandler)
                })
            },
            registerOutsideClose() {
                const bodyClickHandler = (e) => {
                    if (!this.visible) {
                        return;
                    }

                    if (!this.$refs.modal || e.target === this.$refs.modal || this.$refs.modal.contains(e.target)) {
                        return;
                    }

                    this.closeModal()
                }

                document.addEventListener('click', bodyClickHandler)
                this.$once('hook:destroyed', () => {
                    document.removeEventListener('click', bodyClickHandler)
                })
            },
            closeModal() {
                this.$emit('close')
                this.visible = false
            }
        }
    }
</script>