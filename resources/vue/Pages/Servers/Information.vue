<template>
    <SystemInformation :server="$parent.server"/>
</template>

<script>
    import SystemInformation from "@vue/components/Server/partials/SystemInformation"

    export default {
        components: {SystemInformation},
    }
</script>