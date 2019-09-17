<template>
    <div class="form-group" :class="{'is-invalid': httpErrors.has(name), 'is-required': required}">
        <vSelect class="form-control"
                 :options="options"
                 :value="value" @input="setSelected"
                 :reduce="option => option.value"
                 :label="label"
        />
        <label>{{ label }}</label>

        <slot></slot>
        <span class="invalid-feedback" role="alert" v-if="httpErrors.has(name)">
            <strong>{{ httpErrors.first(name) }}</strong>
        </span>
    </div>
</template>

<script>
    import vSelect from '@vue/components/UI/Select'

    export default {
        components: {vSelect},
        props: {
            value: {
                default() {
                    return []
                }
            },
            name: String,
            label: String,
            required: {
                type: Boolean,
                default: false
            },
            options: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        mounted() {
            if (this.autofocus) {
                this.$nextTick(() => this.$refs.input.focus())
            }
        },
        methods: {
            setSelected(value) {
                this.$emit('input', value ? value.value : null)
            }
        }
    }
</script>
