<template>
    <div class="form-group form-group-labeled" :class="{'is-invalid': httpErrors.has(name), 'is-required': required}">
        <textarea :id="name" class="form-control"
                  :placeholder="label"
                  :value="value"
                  ref="input"
                  @input="onInput"></textarea>
        <label :for="name">{{ label }}</label>

        <slot></slot>

        <span class="invalid-feedback" role="alert" v-if="httpErrors.has(name)">
            <strong>{{ httpErrors.first(name) }}</strong>
        </span>
    </div>
</template>

<script>
    import input from "@js/vue/mixins/input"

    export default {
        mixins: [input],
        watch: {
            value() {
                this.$nextTick(this.resize)
            }
        },
        methods: {
            onInput(e) {
                this.$nextTick(this.resize)
                this.$emit('input', e.target.value)
            },
            resize() {
                const $el = this.$refs.input
                $el.style.setProperty('height', 'auto')
                let contentHeight = $el.scrollHeight + 1

                const heightVal = contentHeight + 'px'
                $el.style.setProperty('height', heightVal)
                return this
            }
        },
        computed: {

        },
    }
</script>
