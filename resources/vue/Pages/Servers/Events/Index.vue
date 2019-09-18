<template>
    <div class="w-full">
        <div class="container pl-10">
            <h1>Events</h1>
            <EventsList :server="$parent.server" class="mt-10"/>
        </div>
    </div>
</template>

<script>
    import EventsList from "@vue/components/Server/Events/List";
    export default {
        components: {EventsList}
    }
</script>
