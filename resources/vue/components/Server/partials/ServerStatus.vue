<template>
    <div class="servers-list-item__status">
        <i class="icon fas fa-server"></i>
        <div class="status-indicator" :class="server.status"></div>
    </div>
</template>

<script>
    export default {
       props: {
           server: Object
       }
    }
</script>
