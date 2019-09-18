<template>
    <div class="w-full">
            <List/>
            <CreateForm class="mt-10"/>
    </div>
</template>
<script>
    import CreateForm from '@vue/components/Server/Form/Create'
    import List from '@vue/components/Server/List'

    export default {
        components: {List, CreateForm}
    }
</script>
