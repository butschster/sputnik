<template>
    <div>
        <a href="#" @click="go" class="search__results-list__link">
            <i class="fas fa-fw fa-globe"></i>
           <span class="ml-3">{{ data.domain }}</span>
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

                this.$emit('onClick', this.$link.serverSite(this.data))
            }
        }
    }
</script>