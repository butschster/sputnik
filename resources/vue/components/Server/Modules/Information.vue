<template>
    <section class="section section--border-b">
        <div class="section-header">
            <small>{{ module.title }}</small>
            <span class="badge badge-default">{{ module.status }}</span>
        </div>
        <table class="table" v-if="hasMeta">
            <col width="200px">
            <col>
            <tbody>
            <tr v-for="(value, key) in meta" :key="key">
                <th>{{ key }}</th>
                <td>{{ value }}</td>
            </tr>
            </tbody>
        </table>
    </section>
</template>

<script>
    export default {
        props: {
            module: Object
        },
        computed: {
            hasMeta() {
                return !_.isEmpty(this.module.meta)
            },
            meta() {
                return this.module.meta
            }
        }
    }
</script>