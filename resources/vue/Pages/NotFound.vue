<template>
    <div class="min-h-screen py-16 md:py-20 min-w-full flex flex-col justify-start">
        <a href="#" class="w-full inline-block"><img src="http://demo.designing-world.com/apland-4.2.0/img/core-img/logo.png" class="mx-auto" alt="Logo"></a>
        <div class="py-12 flex-grow flex justify-between items-center">
            <div class="container mx-auto px-4">
                <div class="flex items-center flex-wrap">
                    <div class="w-full md:w-1/2 pr-0 md:pr-4 mb-10 md:mb-0">
                        <img src="http://demo.designing-world.com/apland-4.2.0/img/bg-img/404.png" alt="Image" class="max-w-2xl w-full mx-auto">
                    </div>
                    <div class="w-full md:w-1/2 pl-0 md:pl-4 mb-10 md:mb-0">
                        <h2 class="mb-4 text-4xl font-bold">{{ $t('page_not_found.title') }}</h2>
                        <p class="mb-8">{{ $t('page_not_found.reason') }}</p>
                        <router-link class="btn btn-primary" :to="$link.servers()">
                            {{ $t('page_not_found.button.home') }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        metaInfo: {
            title() {
                return this.$t('page_not_found.title')
            }
        },
        methods: {
            back() {
                this.$router.go(-1)
            }
        },
    }
</script>
