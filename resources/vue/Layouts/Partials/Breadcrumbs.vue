<template>
    <div class="breadcrumbs">
        <ul>
            <li v-for="crumb in crumbs">
                {{ crumb.name }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                crumbs: []
            }
        },
        mounted() {
            this.build()
        },
        watch: {
            '$route': 'build'
        },
        methods: {
            build() {
                // TODO
            }
        }
    }
</script>