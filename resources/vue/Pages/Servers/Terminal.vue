<template>
    <div>
        <h1><i class="fas fa-terminal"></i> Terminal</h1>

        <Terminal :server="$parent.server" />
    </div>
</template>

<script>
    import Terminal from "@vue/components/Server/Terminal/Terminal"
    export default {
        components: {Terminal}
    }
</script>