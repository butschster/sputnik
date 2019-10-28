<template>
    <div class="section my-3">
        <h4>{{ module.title }}</h4>

        <div class="flex">
            <template v-for="field in action.fields">
                <FormText v-model="form[field.key]" :name="field.key" :label="field.title"
                          v-if="field.type == 'Text'" class="w-full mr-8"/>

                <FormNumber v-model="form[field.key]" :name="field.key" :label="field.title"
                          v-if="field.type == 'Number'" class="w-full mr-8"/>

                <FormSelect
                        v-model="form[field.key]"
                        :name="`modules.${module.key}.${field.key}`"
                        :label="field.title"
                        :options="field.meta.options"
                        :multiple="field.type == 'MultiSelect'"
                        v-if="field.type == 'Select' || field.type == 'MultiSelect'"
                        class="w-full mr-8"
                />
            </template>
        </div>
    </div>
</template>

<script>
    import FormText from '@vue/components/Form/Input'
    import FormSelect from '@vue/components/Form/Select'
    import FormNumber from '@vue/components/Form/Number'

    export default {
        components: {FormSelect, FormText, FormNumber},
        props: {
            module: Object
        },
        watch: {
            form: {
                handler(data) {
                    data['key'] = this.module.key
                    this.$emit('onChange', this.module.key, data)
                },
                deep: true
            }
        },
        data() {
            return {
                form: {}
            }
        },
        mounted() {
            this.form = this.action.settings
        },
        computed: {
            action() {
                return this.module.getAction('install')
            }
        }
    }
</script>
