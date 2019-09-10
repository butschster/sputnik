<template>
    <div class="form-group form-group-labeled" :class="{'is-invalid': httpErrors.has(name), 'is-required': required}">
        <input type="text" :id="name" class="form-control"
               :placeholder="label"
               :value="value"
               ref="input"
               @input="$emit('input', $event.target.value)"
               @blur="$emit('blur')"
               @focus="$emit('focus')">
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
        mixins: [input]
    }
</script>
