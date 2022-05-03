<template>
  <div class="conversation-wrapper">
    <div class="conversation-header d-flex px-2 py-2 px-sm-4 py-sm-3 border-bottom">
      <div class="d-flex align-items-center" style="gap: 1rem">
        <div :class="{ 'text-success': isOpponentActive, 'text-danger': !isOpponentActive }"><i class="fa fa-circle" aria-hidden="true"></i></div>
        <h6 class="text-capitalize mb-0" v-if="opponentUser">
          {{ opponentUser.name }}
        </h6>
      </div>
      <div class="ml-auto">
        <a :href="`/user/deals/create?customer=${chatRoom.customer_user_id}`" target="_blank" class="btn btn-primary btn-sm mr-2"><strong>Create Deal</strong></a>
        <button class="btn btn-primary btn-sm" style="border-radius: 50%" type="button" @click="showInformation"><i class="fa fa-info"></i></button>
      </div>
    </div>
    <div class="conversation pt-2 pb-5 px-4" v-chat-scroll="{ always: false, smooth: true, scrollonremoved: true, smoothonremoved: false }" @v-chat-scroll-top-reached="loadLastMessages">
      <!-- <div v-if="hasOlderMessages && !loadingMessages" class="text-center">
        <button type="button" @click="loadOlderMessages" class="btn btn-link btn-sm font-weight-bolder">Load More...</button>
      </div> -->
      <!-- <infinite-loading direction="top" @infinite="infiniteHandler"></infinite-loading> -->
      <!-- <div v-if="loadingMessages" class="mb-2 d-flex justify-content-center" role="status">
        <div class="loader"></div>
      </div> -->
      <div v-if="loadingMessages" class="text-center">
        <div class="loader d-inline-block"></div>
      </div>

      <div v-if="!hasMoreMessages" class="d-flex justify-content-center">
        <div v-if="messages.length" class="chat-start-message">Conversation started at {{ new Date(messages[0].created_at).toDateString() }}.</div>
        <div v-else class="chat-start-message">This is the begenning of your conversation.</div>
      </div>

      <div v-for="(message, index) in messages" :key="index" class="d-flex">
        <message-block :message="message" :user="user"></message-block>
      </div>
      <div v-for="message in queueMessages" :key="message.ts" class="d-flex my-1">
        <div class="message outgoing">
          <div class="bloc text-block">{{ message.message }}</div>
        </div>
      </div>
      <div class="my-2">
        <div v-show="typing" class="chat-bubble">
          <div class="typing">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="conversation-creator px-md-2 py-2">
      <form @submit.prevent="sendMessage" class="message-compose-form border mb-0">
        <label class="bg-file px-md-2 d-inline-flex align-items-center">
          <input type="file" @change="sendFile" style="display: none" />
          <i class="fa fa-plus-circle"></i>
        </label>
        <input v-model="newMessage" type="text" class="py-md-2 px-md-2" @keyup="sendTypingEvent" placeholder="Enter text here..." />
        <button type="submit" class="btn btn-send px-md-2"><i class="fa fa-paper-plane"></i></button>
      </form>
    </div>

    <chat-info :chat-room="chatRoom"></chat-info>
  </div>
</template>

<script>
import axios from "axios";
import MessageBlock from "./MessageBlock.vue";
import Swal from "sweetalert2";
import ChatInfo from "./ChatInfo.vue";

export default {
  components: { MessageBlock, ChatInfo },
  name: "ChatBox",
  props: ["user", "vendorUserId", "chatRoom"],
  data() {
    return {
      newMessage: "",
      messages: [],
      queueMessages: [],
      activeUsers: [],
      opponentUser: null,
      typing: false,
      loadingMessages: false,
      hasMoreMessages: true,
      moreMessagesUrl: null,
    };
  },
  async created() {
    axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("token");
    // this.user = this.$store.getters['user/user'];
    // Get or create chat room
    // await this.getOrCreateChatRoom();
    // Join the chat room
    await this.joinChatRoom();
    // Fetch opponent user
    this.fetchOpponentUser();
    // Load last messages
    this.loadLastMessages();

    // Reset typing status peridiocally
    setInterval(() => {
      this.typing = false;
    }, 2000);
  },
  methods: {
    fetchOpponentUser() {
      this.opponentUser = this.chatRoom.customer_user;
    },

    joinChatRoom() {
      window.channel = window.Echo.join("chat-channel-" + this.chatRoom.id)
        .here((users) => {
          this.activeUsers = users;
          console.log(users);
        })
        .joining((user) => {
          this.activeUsers.push(user);
        })
        .leaving((user) => {
          this.activeUsers = this.activeUsers.filter((u) => u.id !== user.id);
        })
        .listen(".new-message", (event) => {
          this.messages.push(event.message);
          this.markSeen();
        })
        .listenForWhisper("typing", (e) => {
          this.typing = true;
          console.log(e);
        })
        .error((error) => {
          console.error(error);
        });
    },

    sendTypingEvent() {
      window.channel.whisper("typing", { user_id: this.user.id });
      console.log("Whispering...");
    },

    sendMessage() {
      this.newMessage = this.newMessage.trim();
      if (!this.newMessage) return;
      let ts = Date.now();
      this.queueMessages.push({
        message: this.newMessage,
        type: "text",
        ts: ts,
      });

      let data = {
        message: this.newMessage,
        ts: ts,
      };
      this.newMessage = "";

      axios
        .post(`/api/messages/${this.chatRoom.id}`, data)
        .then((response) => {
          this.messages.push(response.data.data);
          this.queueMessages.forEach((element) => {
            if (element.ts == response.data.ts) {
              this.queueMessages.splice(this.queueMessages.indexOf(element), 1);
            }
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    sendFile(e) {
      let file = e.target.files[0];
      let formData = new FormData();
      formData.append("file", file);
      formData.append("type", "file");
      axios({
        method: "POST",
        url: `/api/messages/${this.chatRoom.id}`,
        data: formData,
        headers: {
          "X-Socket-Id": window.Echo.socketId(),
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          this.messages.push(response.data.data);
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 422) {
            Swal.fire({
              title: "OOPS",
              text: "This file type is not allowed.",
              icon: "error",
            });
          }
        });
    },

    loadLastMessages() {
      console.log("Loading older messages");
      if (!this.hasMoreMessages) {
        return;
      }
      this.loadingMessages = true;
      let url = this.moreMessagesUrl || `/api/chats/${this.chatRoom.id}/messages`;
      axios
        .get(url)
        .then((response) => {
          this.messages.unshift(...response.data.data.reverse());
          this.loadingMessages = false;
          this.markSeen();
          if (response.data.links.next) {
            this.moreMessagesUrl = response.data.links.next;
          } else {
            this.hasMoreMessages = false;
          }
        })
        .catch((error) => {
          console.log("Error while loading messages", error);
        });
    },

    markSeen() {
      axios.post("/api/mark-seen-messages", {
        chat_room_id: this.chatRoom.id,
        last_message_id: this.messages[this.messages.length - 1].id,
      });
    },

    showInformation() {
      window.dispatchEvent(new Event("show-chat-info"));
    },
  },

  computed: {
    isOpponentActive() {
      for (let [key, user] of Object.entries(this.activeUsers)) {
        if (user.id == this.opponentUser.id) {
          return true;
        }
      }
      return false;
    },
  },
};
</script>

<style scoped>
.chat-start-message {
  font-size: 0.8rem;
  background-color: #f5f5f5;
  color: #1a1b22;
  font-weight: 600;
  font-family: Arial, Helvetica, sans-serif;
  padding: 5px 10px;
  line-height: 1;
  border-radius: 2.5rem;
}
</style>
