<template>
    <div>
        <a href="#" @click="go" class="search__results-list__link flex items-center">
            <i class="fa-fw fas fa-server"></i>
            <span class="ml-3 flex-1">
                {{ data.name }}
            </span>
            <span class="text-gray-500 text-sm">{{ data.ip }}</span>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            data: Object
        },
        methods: {
            go(e) {
                e.preventDefault()

                this.$emit('onClick', this.$link.server(this.data.id))
            }
        }
    }
</script>