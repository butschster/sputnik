<template>
    <div>
        <h1>
            Scheduler
        </h1>

        <section class="section pb-8 my-10">
            <div class="section-header">
                New scheduled task
                <p>You can easily schedule cron jobs on your server</p>
            </div>
            <input type="hidden" name="user" value="root">

            <div class="form-group form-group-labeled is-required ">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                <label for="name">Name</label>
            </div>

            <div class="form-group form-group-labeled ">
                <input type="text" class="form-control"
                       name="command" id="command" placeholder="Command">
                <label for="command">Command</label>
            </div>

            <div class="form-group form-group-labeled is-required">
                <input type="text" class="form-control" name="cron" id="cron"
                       value="" placeholder="Cron expression">
                <label for="cron">Cron expression</label>

                <small id="passwordHelpBlock" class="form-text text-muted">
                    You can use named expressions like [@hourly, @daily, @monthly]
                </small>
            </div>

            <div class="form-group mb-0">
                <button class="btn btn-primary">Schedule</button>
            </div>
        </section>

        <div class="mt-10">
            <h4>Scheduled jobs</h4>
            <table class="table mb-0">
                <col>
                <col width="100px">
                <col width="100px">
                <col>
                <col width="200px">
                <col width="100px">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Cron</th>
                    <th>User</th>
                    <th>Command</th>
                    <th>Next run</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="job in jobs" :key="job.id">
                    <th>{{ job.name }} <br><small class="text-muted">{{ job.id }}</small></th>
                    <th>{{ job.cron }}</th>
                    <td>{{ job.user }}</td>
                    <td>{{ job.command }}</td>
                    <td>{{ job.nextRunDate() }}</td>
                    <td><span class="badge badge-dark">{{ job.taskStatus() }}</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                jobs: [],
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {

                } catch (e) {

                }

                this.loading = false
            }
        }
    }
</script>