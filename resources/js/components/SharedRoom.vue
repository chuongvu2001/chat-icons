<template>
    <div class="card">
        <div class="card-header msg_head">
            <div class="bd-highlight">
                <div class="user_info">
                    <span>{{ currentRoom.name }}</span>
                </div>
                <div class="text-white ml-3">
                    {{ currentRoom.description }}
                </div>
            </div>
        </div>
        <div class="card-body msg_card_body" id="shared_room">
            <MessageItem v-for="message in messages" :key="message.id" :message="message"/>
        </div>
        <div class="card-footer">
            <div class="input-group">
                <div class="dropdown">
                    <button class="dropbtn">&#128512;</button>
                    <div class="dropdown-content" id="drop-content">
                    </div>
                </div>
                <textarea
                    v-model="inputMessage"
                    name=""
                    class="form-control type_msg"
                    data-emoji-input="unicode"
                    placeholder="Type your message...aaa"
                    data-emojiable="true"
                    @keyup.enter="saveMessage"
                    v-on:change="checkIcon"
                    ref="icon"
                />
                <div class="input-group-append">
                    <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MessageItem from './MessageItem'

export default {
    props: {
        messages: {
            type: Array,
            required: true
        },
        currentRoom: {
            type: Object,
            required: true
        }
    },
    components: {
        MessageItem
    },
    data() {
        return {
            inputMessage: '',
            icons: ''
        }
    },
    methods: {
        saveMessage() {
            this.$emit('saveMessage', this.inputMessage)
            this.inputMessage = ''
        },
        async checkIcon() {
            const response = await axios.post('/api/check-icon', {
                content: this.inputMessage,
            });

            this.icons = response.data;
            document.getElementById('drop-content').innerHTML = "";
            for (const [key, value] of Object.entries(response.data)) {
                document.getElementById('drop-content').innerHTML
                    +=
                    `<a href="javascript:;" class="icon">${value}:${key}:</a>`
            }

            let icons = document.querySelectorAll('.icon');
            [...icons].map(icon => icon.addEventListener('click', () => {
                let msg = this.inputMessage;
                msg += icon.innerHTML;
                msg = msg.replaceAll(/\:[a-zA-Z\-\_]+\:?/g, '');
                this.inputMessage = msg;
            }));
        }
    }
}
// icons.map(item => console.log(item));
</script>

<style>
.dropbtn {
    background-color: #04AA6D;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}
</style>
