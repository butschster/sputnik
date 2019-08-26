<template>
    <div>
        <CreateForm class="mb-10"/>
        <List />
    </div>
</template>
<script>
    import CreateForm from '@vue/components/Server/Form/Create'
    import List from '@vue/components/Server/List'

    export default {
        components: {List, CreateForm},
        methods: {},
    }
</script>
