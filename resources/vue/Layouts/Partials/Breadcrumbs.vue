<template>
    <div class="breadcrumbs w-full">
        <div class="container pl-10">
            <ul>
                <li v-for="crumb in crumbs">
                    {{ crumb.name }}
                </li>
            </ul>
        </div>
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
