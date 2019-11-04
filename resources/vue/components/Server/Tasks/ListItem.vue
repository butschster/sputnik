<template>
    <tr>
        <th>
            <router-link :to="$link.serverTask(task)">
                <strong>{{ task.name }}</strong>
            </router-link>
        </th>
        <td class="text-right">
            <BadgeTaskStatus :task="task"/>
        </td>
        <td class="text-right">
            <span class="badge" :class="{'badge-success' : task.is_successful, 'badge-danger': !task.is_successful}">
                {{ task.is_successful ? 'Yes' : 'No' }}
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