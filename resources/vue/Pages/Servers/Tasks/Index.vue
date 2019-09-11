<template>
    <router-view/>
</template>

<script>
    export default {
        computed: {
            server() {
                return this.$parent.server
            }
        }
    }
</script>