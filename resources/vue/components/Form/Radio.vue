<template>
    <div class="form-group form-group-radio">
        <input :id="label"
               :name="name"
               type="radio"
               class="hidden"
               :value="value"
               @change="onChange"
               :checked="shouldBeChecked"
        />
        <label :for="label">
            <span></span>
            {{ label }}
        </label>
    </div>
</template>

<script>
    export default {
        model: {
            prop: 'modelValue',
            event: 'change'
        },
        props: {
            value: {
                default: null
            },
            modelValue: {
                default: null
            },
            name: String,
            label: String,
        },
        methods: {
            onChange() {
                this.toggle()
            },
            toggle() {
                this.$emit('change', this.value)
            }
        },
        computed: {
            shouldBeChecked() {
                return this.modelValue == this.value
            }
        },
    }
</script>