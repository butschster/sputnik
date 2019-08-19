<template>
    <div class="md:flex min-h-screen">
        <div class="w-full md:w-1/2 bg-white flex items-center justify-center ">
            <div class="max-w-sm m-8">
                <div class="text-5xl">404</div>

                <div class="w-16 h-1 bg-purple-light my-3 md:my-6"></div>

                <p class="text-grey-darker text-2xl md:text-3xl font-light mb-8 leading-normal">Sorry, the page you are looking for could not be found.</p>
                <button class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg" @click="back">
                    Go back
                </button>
            </div>
        </div>
        <div class="relative pb-full md:flex md:pb-0 md:min-h-screen w-full md:w-1/2">
            <div class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
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