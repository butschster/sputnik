<template>
    <div class="min-h-screen pt-4 md:pr-10 min-w-full max-w-5xl">
        <a href="#" class="logo block mb-6 mx-auto"><img src="img/core-img/logo.png" alt="Logo"></a>
        <div class="flex mb-4 align-center">
            <div class="w-full md:w-1/2">
                <img src="img/bg-img/404.png" alt="Image">
            </div>
            <div class="w-full md:w-1/2">
                <h2 class="mb-4">OOPS! <br>Page not found</h2>
                <p class="mb-5">We couldn't find any results for your search. Try again.</p>
                <router-link class="btn btn-primary"  :to="$link.servers()">
                    Check Updates
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        metaInfo: {
            title: 'Page not found'
        },
        methods: {
            back() {
                this.$router.go(-1)
            }
        },
    }
</script>
