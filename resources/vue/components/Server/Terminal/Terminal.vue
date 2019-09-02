<template>
    <div ref="terminal"></div>
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
                rows: 40
            })

            this.terminal.open(this.$refs.terminal)

            this.ws = new WebSocket("ws:localhost:8080")

            this.ws.onopen = (event) => {
                this.terminal.attach(this.ws, false, false)

                window.setInterval(() => {
                    this.ws.send(JSON.stringify({command: "refresh"}));
                }, 500);
            }

            this.ws.onerror = (event) => {
                this.terminal.detach(this.ws);
            }

            this.terminal.on('data', (data) => {
                this.ws.send(JSON.stringify(
                    {command: 'message', message: data}
                ))
            })

            setTimeout(() => this.connectServer(), 1000)
        },
        methods: {
            connectServer() {
                this.ws.send(JSON.stringify(
                    {command: 'auth', id: this.server.id}
                ));
                this.terminal.fit();
                this.terminal.focus();
            }

        }
    }
</script>
