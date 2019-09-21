<template>
    <div class="divTableRow">
        <div class="divTableCell">
            <router-link :to="$link.serverTask(task)">
             <strong>{{ task.name }}</strong>
            </router-link></div>
        <div class="divTableCell"><BadgeTaskStatus :task="task"/></div>
        <div class="divTableCell"><BadgeTimeFrom :date="task.created_at" /></div>
    </div>

</template>

<script>
    export default {
        props: {
            task: Object
        }
    }
</script>
<style>

</style>
