<template>
    <div>
        <section class="section section--border-b">
            <div class="alert-warning alert mb-0 p-4">
                {{ $t('server.installation.message.not_supported', {info: server.sys_info.name}) }}
            </div>
        </section>
        <Destroy :server="server"/>
    </div>
</template>

<script>
    import Destroy from "@vue/components/Server/partials/Destroy"

    export default {
        components: {Destroy},
        props: {
            server: Object
        }
    }
</script>
