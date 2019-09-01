<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            New daemon
            <p>Supervisor is a client/server system that allows its users to monitor and control a number of processes on UNIX-like operating systems..</p>
        </div>
        <div class="flex">
            <FormInput v-model="form.command" label="Command" name="command" class="flex-1 mr-8" required/>
            <FormInput v-model="form.processes" label="Number of processes" name="processes" class="mr-8" required/>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">Start</button>
            </div>
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
                    command: null,
                    processes: 1,
                    user: 'root'
                },
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const daemon = await this.$api.serverSupervisor.store(this.server.id, this.form)
                    this.$emit('created', daemon)

                    this.$notify({
                        text: 'Daemon successfully created',
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
                    command: null,
                    processes: 1,
                    user: 'root'
                }
            }
        }
    }
</script>
