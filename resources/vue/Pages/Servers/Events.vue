<template>
    <EventsList :server="$parent.server" class="mt-10" />
</template>

<script>
    import EventsList from "@vue/components/Server/Events/List";
    export default {
        components: {EventsList}
    }
</script>