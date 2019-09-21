<template>
    <div>
        <h1>{{ $t('server.events.title') }}</h1>
        <EventsList :server="$parent.server" class="mt-10"/>
    </div>
</template>

<script>
    import EventsList from "@vue/components/Server/Events/List";

    export default {
        components: {EventsList}
    }
</script>
