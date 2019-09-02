<template>
    <div ref="terminal">
        hello
    </div>
</template>

<script>
    import * as Terminal from 'xterm/dist/xterm'
    import * as fit from 'xterm/dist/addons/fit/fit'
    import * as attach from 'xterm/dist/addons/attach/attach'

    export default {
        props: {
            server: Object
        },
        mounted() {
            Terminal.applyAddon(fit)
            Terminal.applyAddon(attach)

            this.terminal = new Terminal({
                cols: 80,
                rows: 24
            })

            this.terminal.open(this.$refs.terminal)

            this.ws = new WebSocket("ws:localhost:8080")

            this.ws.onopen = (event) => {
                this.terminal.attach(this.ws, false, false)
            }

            this.ws.onerror = (event) => {
                this.terminal.detach(this.ws);
                console.log("Connection Closed")
            }

            this.terminal.on('data', (data) => {
                console.log(data)
                this.ws.send(JSON.stringify(
                    {command: 'message', message: data}
                ))


                if (data == "0") {
                    this.terminal.write(data);
                }
            })

            setTimeout(() => this.connectServer(), 1000)
        },
        methods: {
            resizeScreen() {
                this.terminal.fit()
            },
            connectServer() {
                this.ws.send(JSON.stringify(
                    {command: 'auth', public_key: this.server.public_key}
                ));
                this.terminal.fit();
                this.terminal.focus();
            }

        }
    }
</script>
