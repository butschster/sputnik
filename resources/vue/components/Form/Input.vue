<template>
    <div class="form-group form-group-labeled" :class="{'is-invalid': httpErrors.has(name), 'is-required': required}">
        <input type="text" :id="name" class="form-control"
               :placeholder="label"
               :value="value"
               ref="input"
               @input="$emit('input', $event.target.value)">
        <label :for="name">{{ label }}</label>

        <span class="invalid-feedback" role="alert" v-if="httpErrors.has(name)">
            <strong>{{ httpErrors.first(name) }}</strong>
        </span>
    </div>
</template>

<script>
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
</script>