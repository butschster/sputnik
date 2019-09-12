<template>
    <span class="badge">{{ date | moment("from") }}</span>
</template>

<script>
    export default {
        props: {
            date: String
        }
    }
</script>
