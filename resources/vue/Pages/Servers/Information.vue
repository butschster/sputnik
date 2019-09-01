<template>
    <div>
        <h1>System information</h1>

        <SystemInformation :server="$parent.server"/>
    </div>
</template>

<script>
    import SystemInformation from "@vue/components/Server/partials/SystemInformation"

    export default {
        components: {SystemInformation},
    }
</script>