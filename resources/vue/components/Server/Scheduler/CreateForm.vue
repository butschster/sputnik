<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            New scheduled task
            <p>ou can easily schedule cron jobs on your server.</p>
        </div>
        <div class="flex">
            <FormInput v-model="form.name" label="Name" name="name" class="mr-8" required autofocus/>
            <FormInput v-model="form.command" label="Command" name="command" class="flex-1 mr-8" required/>
            <FormInput v-model="form.cron" label="Cron expression" name="cron" class="mr-8" required>
                <small class="form-text text-muted">
                    You can use named expressions like [@hourly, @daily, @monthly]
                </small>
            </FormInput>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">Schedule</button>
            </div>
        </div>

        <div>
            <span class="badge cursor-pointer mr-2" :class="{'badge-primary': form.cron == expr.expression}" v-for="expr in expressions" @click="form.cron = expr.expression">
                {{ expr.name }}
            </span>
        </div>
    </section>
</template>

<script>
    import FormInput from '@vue/components/Form/Input.vue'

    export default {
        components: {FormInput},
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                form: {
                    name: null,
                    command: null,
                    cron: '* * * * *',
                    user: 'root'
                },
                expressions: [
                    {
                        name: 'yearly',
                        expression: '0 0 1 1 *',
                    },
                    {
                        name: 'monthly',
                        expression: '0 0 1 * *',
                    },
                    {
                        name: 'weekly',
                        expression: '0 0 * * 0',
                    },
                    {
                        name: 'daily',
                        expression: '0 0 * * *',
                    },
                    {
                        name: 'hourly',
                        expression: '0 * * * *',
                    },
                    {
                        name: 'every minute',
                        expression: '* * * * *',
                    },
                ]
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const job = await this.$api.serverCron.store(this.server.id, this.form)
                    this.$emit('created', job)

                    this.$notify({
                        text: 'Cron job successfully created',
                        type: 'success'
                    });

                    this.clear()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            clear() {
                this.form = {
                    name: null,
                    command: null,
                    cron: '* * * * *',
                    user: 'root'
                }
            }
        }
    }
</script>
