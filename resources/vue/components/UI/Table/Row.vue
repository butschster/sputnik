<template>
    <tr>
        <TableCol v-for="(col, index) in data" :data="col" :key="index"/>
    </tr>
</template>

<script>
    import TableCol from './Col'

    export default {
        components: {TableCol},
        props: {
            data: Object
        }
    }
</script>
