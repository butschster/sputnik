<template>
    <section class="section">
        <div class="alert-warning alert mb-0 p-4 flex justify-between">
            Sorry, your OS {{ server.sys_info.name }} currently is not supported!

            <button class="btn btn-danger-outline btn-sm" @click="destroy">Delete</button>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            server: Object
        },
        methods: {
            destroy() {

            }
        }
    }
</script>
