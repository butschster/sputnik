<template>
    <div class="w-full">
        <div class="container pl-10">
            <h1>Tasks</h1>
        </div>
            <TasksList :server="$parent.server" class="mt-10"/>
    </div>
</template>

<script>
    import TasksList from "@vue/components/Server/Tasks/List"

    export default {
        components: {TasksList}
    }
</script>
