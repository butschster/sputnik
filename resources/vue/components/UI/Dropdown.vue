<template>
    <div class="dropdown" ref="dropdown" :class="{'open': visible}" :id="`dropdown-${name}`">
        <div class="dropdown-title" @click="toggle">
            <slot name="title"></slot>
            <i class="icon fas" :class="{'fa-chevron-down': !visible, 'fa-chevron-up': visible}"></i>
        </div>

        <div class="dropdown-menu">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: String,
            state: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                visible: false
            }
        },
        mounted() {
            this.registerOutsideClose()

            this.$dropdown.event
                .$on('show', (dropdown) => {
                    if (this.name == dropdown) {
                        this.visible = true
                    }
                })
                .$on('close', (dropdown) => {
                    if (this.name == dropdown) {
                        this.visible = false
                    }
                })
                .$on('close-all', (dropdown) => {
                    this.visible = false
                })
        },
        watch: {
            visible(state) {
                this.$emit('visible', state)
            },
            state(state) {
                this.visible = state
            }
        },
        methods: {
            toggle() {
                this.visible = !this.visible
            },
            registerOutsideClose() {
                const bodyClickHandler = (e) => {
                    if (!this.$refs.dropdown || e.target === this.$refs.dropdown || this.$refs.dropdown.contains(e.target)) {
                        return;
                    }

                    this.close()
                }

                document.addEventListener('click', bodyClickHandler)
                this.$once('hook:destroyed', () => {
                    document.removeEventListener('click', bodyClickHandler)
                })
            },
            close() {
                this.$emit('close')
                this.visible = false
            }
        }
    }
</script>
