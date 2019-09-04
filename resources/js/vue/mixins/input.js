export default {
    props: {
        value: [String, Number],
        name: String,
        label: String,
        required: {
            type: Boolean,
            default: false
        },
        autofocus: {
            type: Boolean,
            default: false
        }
    },
    mounted() {
        if (this.autofocus) {
            this.$nextTick(() => this.$refs.input.focus())
        }
    }
}