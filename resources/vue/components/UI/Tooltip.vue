<template>
    <div v-show="show">
        <slot></slot>
    </div>
</template>

<script>
    import Popper from 'popper.js'

    export default {
        props: {
            state: {
                type: Boolean,
                default: false
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
        watch: {
            state(state) {
                this.show = state
            }
        },
        data() {
            return {
                show: true
            }
        },
        methods: {
            toggle() {
                this.show = !this.show
            },
            hide() {
                this.show = false
            }
        }
    }
</script>
