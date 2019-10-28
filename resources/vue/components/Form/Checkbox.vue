<template>
    <div class="form-group form-group-checkbox">
        <input class="form-checkbox" type="checkbox"
               :id="name"
               :checked="value"
               @change="$emit('input', $event.target.checked)">
        <label class="form-check-label ml-2" :for="name">{{ label }}</label>
    </div>
</template>

<script>
    import input from "@js/vue/mixins/input"

    export default {
        mixins: [input],
        computed: {
            checkboxState() {
                if (Array.isArray(this.model)) return this.model.indexOf(this.value) !== -1
                return this.model || Boolean(this.lv)
            },
        }
    }
</script>