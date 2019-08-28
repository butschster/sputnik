<template>
    <div>
        <CreateForm :server="$parent.server" @created="onCreate"/>
    </div>
</template>

<script>
    import CreateForm from "@vue/components/Server/Sites/Form/Create"

    export default {
        components: {CreateForm},
        methods: {
            onCreate(site) {

            }
        }
    }
</script>