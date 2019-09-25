<template>
    <div class="p-5 bg-gray-100" @click="$emit('onRemove', module)">
        {{ module.title }}
    </div>
</template>

<script>
    export default {
        props: {
            module: Object
        }
    }
</script>