<template>
    <div id="app" class="min-w-full min-h-screen">
        <div class="flex min-h-screen">
            <aside class="sidebar">

            </aside>
            <div class="flex-1">
                <Navbar />
                <div class="container pt-10 px-12 m-auto">
                    <router-view/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from '@vue/components/Header/Navbar'

    export default {
        components: {Navbar}
    }
</script>
