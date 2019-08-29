<template>
    <VueElementLoading :active="loading" class="preloader" :spinner="spinner" :color="color" size="70" :text="text">

    </VueElementLoading>
</template>

<script>
    import VueElementLoading from 'vue-element-loading'

    export default {
        components: {VueElementLoading},
        props: {
            loading: {
                type: Boolean
            },
            spinner: {
                type: String,
                default() {
                    return 'bar-fade-scale'
                }
            },
            color: {
                type: String,
                default() {
                    return '#3182ce'
                }
            },
            text: String
        }
    }
</script>
