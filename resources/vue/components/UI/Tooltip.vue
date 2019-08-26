<template>
    <div v-if="show" v-click-outside="hide" v-on:toggle="toggle">
        <slot></slot>
    </div>
</template>

<script>
    import Popper from 'popper.js'

    export default {
        props: {
            show: {
                type: Boolean,
                default() {
                    return true;
                }
            },
            reference: {
                required: true,
            },
            placement: {
                type: String,
                default() {
                    return 'bottom-end'
                }
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.setupPopper(this.reference.dropdown)
            })
        },
        methods: {
            toggle() {
                this.show = !this.show
            },
            hide() {
                this.show = false
            },
            setupPopper(ref) {
                ref.style.position = 'relative'
                if (this.popper === undefined) {
                    if (this.show) {
                        this.popper = new Popper(ref, this.$el, {
                            placement: this.placement
                        })
                    }
                } else {
                    this.popper.scheduleUpdate()
                }
            }
        }
    }
</script>
