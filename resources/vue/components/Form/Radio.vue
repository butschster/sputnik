<template>
    <div class="form-group form-group-radio">
        <input :id="label"
               :name="name"
               type="radio"
               class="hidden"
               :value="value"
               @change="onChange"
               :checked="state"
        />
        <label :for="label">
            <span></span>
            {{ label }}
        </label>
    </div>
</template>

<script>
    import input from "@js/vue/mixins/input"
    export default {
        model: {
            prop: 'modelValue',
            event: 'input'
        },
        mixins: [input],
        props: {
            checked: {
                type: Boolean,
                default: false,
            },
        },
        methods: {
            onChange() {
                this.toggle();
            },
            toggle() {
                this.$emit('input', this.state ? '' : this.value);
            }
        },
        watch: {
            checked(newValue) {
                if (newValue !== this.state) {
                    this.toggle();
                }
            }
        },
        computed: {
            state() {
                if (this.modelValue === undefined) {
                    return this.checked;
                }
                return this.modelValue === this.value;
            }
        },
    }
</script>