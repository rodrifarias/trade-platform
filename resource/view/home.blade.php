@extends('template')

@section('content')
    <div id="app">
        <div>
            <input class="input-name" v-model="account.name" />
        </div>
        <div>
            <input class="input-email" v-model="account.email" />
        </div>
        <div>
            <input class="input-document" v-model="account.document" />
        </div>
        <div>
            <input class="input-password" type="password" v-model="account.password" />
        </div>
        <span class="span-message">@{{ message }}</span>
        <button class="button-fill" @click="fill">Fill</button>
        <button class="button-confirm" @click="confirm">Confirm</button>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script>
        (() => {
            const { createApp, ref } = Vue
            const socket = io('ws://localhost:8080', { transports: ['websocket'] });

            createApp({
                data() {
                    return {
                        message: '',
                        account : {
                            name: '',
                            email: '',
                            document: '',
                            password: '',
                        },
                    }
                },
                methods: {
                    async confirm() {
                        const response = await fetch("http://localhost/api/signup", {
                            method: "post",
                            headers: {
                                "content-type": "application/json"
                            },
                            body: JSON.stringify(this.account)
                        });
                        await response.json();
                        this.message = 'Account created successfully!'
                    },
                    fill() {
                        this.account.name = 'Rodrigo Farias'
                        this.account.email = 'rodrigo.farias@outlook.com'
                        this.account.document = '01122306016'
                        this.account.password = '123ACb@!'
                    }
                },
            }).mount('#app')
            // socket.on('connect', () => {
            //     socket.emit('event','hello, hyperf', console.log);
            //     socket.emit('join-room','room1', console.log);
            //     setInterval(function () {
            //         socket.emit('say','{"room":"room1", "message":"Hello Hyperf."}');
            //     }, 1000);
            // });
            // socket.on('event', console.log);
        })()
    </script>
@endsection
