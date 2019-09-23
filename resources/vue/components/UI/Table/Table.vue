<template>
    <div>
        <table class="table" v-if="hasData">
            <col v-for="head in structure" :width="head.width || null">
            <thead>
            <tr>
                <th v-for="head in structure" :class="head.headClasses || null">
                    {{ $t(head.title) }}
                </th>
            </tr>
            </thead>
            <tbody>
            <TableRow v-for="(row, index) in structuredData" :data="row" :key="index"/>
            </tbody>
        </table>
        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" :src="emptyImage" width="150px">
            <h3 class="mb-0">{{ emptyMessage }}</h3>
        </div>
    </div>
</template>

<script>
    import TableRow from "./Row"

    export default {
        components: {TableRow},
        props: {
            structure: {
                type: Object,
                required: true
            },
            data: Array,
            emptyImage: {
                type: String,
                default() {
                    return 'https://image.flaticon.com/icons/svg/1681/1681318.svg'
                }
            },
            emptyMessage: {
                type: String,
                default() {
                    return this.$t('server.tasks.message.empty_results')
                }
            }
        },
        computed: {
            structuredData() {
                return this.data.map(item => {
                    return _.forEach(item, (value, key) => {
                        if (!this.structure.hasOwnProperty(key)) {
                            return null
                        }
                        let itemStructure = this.structure[key]
                        itemStructure['value'] = value

                        return itemStructure
                    })
                })
            },
            hasData() {
                return this.data.length > 0
            }
        }
    }
</script>
