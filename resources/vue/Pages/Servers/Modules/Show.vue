<template>
    <div>
        <Loader :loading="loading"/>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false
            }
        }
    }
</script>