<template>
    <TasksList :server="$parent.server" class="mt-10"/>
</template>

<script>
    import TasksList from "@vue/components/Server/Tasks/List"
    export default {
        components: {TasksList}
    }
</script>