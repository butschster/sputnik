<template>
    <Members :team="$parent.team" />
</template>

<script>
    import Members from '@vue/components/User/Teams/Members'
    export default {
        components: {Members}
    }
</script>