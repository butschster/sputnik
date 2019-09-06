<template>
    <tr>
        <th>
            <router-link :to="taskLink">
                <strong>{{ task.name }}</strong>
            </router-link>
        </th>
        <td class="text-right">
            <BadgeTaskStatus :task="task"/>
        </td>
        <td class="text-right">
            <small class="badge">{{ task.created_at | moment("from") }}</small>
        </td>
    </tr>
</template>

<script>
    import BadgeTaskStatus from "@vue/components/UI/Badge/TaskStatus"
    export default {
        components: {BadgeTaskStatus},
        props: {
            task: Object
        },
        computed: {
            taskLink() {
                return this.$link.serverTask(this.task)
            }
        }
    }
</script>