<template>
    <div>
        <h1>Tasks</h1>
        <TasksList :server="$parent.server" class="mt-10"/>
    </div>
</template>

<script>
    import TasksList from "@vue/components/Server/Tasks/List"

    export default {
        components: {TasksList}
    }
</script>