<template>
    <tr>
        <th>
            <router-link :to="$link.serverTask(task)">
                <strong>{{ task.name }}</strong>
            </router-link>
        </th>
        <td class="text-right">
            <BadgeTaskStatus :task="task"/>

            <span class="ml-5 badge" :class="{'badge-success' : task.is_successful, 'badge-danger': !task.is_successful}">
                <strong>[{{ task.exit_code }}]</strong> {{ task.exit_code_text }}
            </span>
        </td>
        <td class="text-right">
            <BadgeTimeFrom :date="task.created_at" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            task: Object
        }
    }
</script>