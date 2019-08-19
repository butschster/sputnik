<template>
    <VueElementLoading :active="loading" class="preloader"/>
</template>

<script>
    import VueElementLoading from 'vue-element-loading'

    export default {
        components: {VueElementLoading},
        props: ['loading']
    }
</script>