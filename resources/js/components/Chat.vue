<template>
    <div class="container bg-gray-light p-2">
        <div class="card-body pt-1 overflow-auto" id="chat">
            <div v-for="message in messages" class="row msg_container base_receive my-2 shadow-sm bg-light">
                <div v-if="message.current" class="col-md-10 col-xs-10 bg-light">
                    <div class="messages msg_receive">
                        <p>{{message.message}}</p>
                    </div>
                </div>
                <div v-if="!message.current" class="col-md-2 col-xs-2 avatar">
                    <img
                        v-bind:src="message.img"
                        class=" img-responsive ">
                </div>
                <div v-if="message.current" class="col-md-2 col-xs-2 avatar">
                    <span>Вы</span>
                </div>
                <div v-if="!message.current" class="col-md-10 col-xs-10 bg-light">
                    <div class="messages msg_receive">
                        <p>{{message.message}}</p>
                        <a v-bind:href="'/user/' + message.user.id">{{message.user.name}}</a>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <input type="text" class="form-control card-body bg-gray-light pt-1" v-model="textMessage"
               @keyup.enter="sendMessage">
    </div>

</template>
<script>
    export default {
        data() {
            return {
                messages: [],
                textMessage: ''
            }
        },
        mounted() {
            window.Echo.channel('reviewwa_database_chat').listen('Message', ({message}) => {
                this.messages = this.checkSize(this.messages);
                this.messages.push({message: message.message, user: message.user, img: message.img , current: false});
                this.$nextTick(function () {
                    document.querySelector('#chat').scrollTo(0, document.querySelector('#chat').scrollHeight);
                })
            })
        },
        methods: {
            checkSize(arr) {
                if (arr.length>=20) {
                    arr.shift()
                }
                return arr;
            },

            sendMessage() {
                if (this.textMessage.replace(/ +/g, ' ').trim() !== '')
                {
                    axios.post('/messages', {body: this.textMessage});
                    this.messages = this.checkSize(this.messages);
                    this.messages.push({message: this.textMessage, current: true,});
                    this.textMessage = '';
                    this.$nextTick(function () {
                        document.querySelector('#chat').scrollTo(0, document.querySelector('#chat').scrollHeight);
                    })
                }
            }
        }
    }
</script>
