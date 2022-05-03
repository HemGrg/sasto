<template>
  <div>
    <div v-if="loading">
      <loading-inbox-list></loading-inbox-list>
    </div>
    <template v-if="chatRooms.data">
      <template v-for="chatRoom in chatRooms.data">
        <a
          v-if="chatRoom.last_message_id"
          v-bind:key="chatRoom.index"
          class="inbox-item d-md-flex py-2 py-md-3 px-2 px-sm-3 px-md-4"
          style="gap: 1.2rem; cursor: pointer"
          :href="`/chat/${chatRoom.id}`"
        >
          <div class="chat-img-wrapper">
            <img class="chat-user-img" :src="chatRoom.opponent.avatar_url" :alt="chatRoom.customer_name" />
          </div>
          <div class="chat-info-wrapper align-self-center">
            <div class="chat-name">{{ chatRoom.opponent.name }}</div>
            <div v-if="chatRoom.has_unseen_messages && chatRoom.id != activeChatRoomId" style="font-size: 0.8rem" class="d-md-block d-none new-message-label"><i class="fa fa-envelope-o mr-1"></i>New Message</div>
            <div v-else style="font-size: 0.8rem" class="d-md-block d-none">{{ chatRoom.last_message_at }}</div>
          </div>
        </a>
      </template>
    </template>
  </div>
</template>

<script>
import LoadingInboxList from "./LoadingInboxList.vue";
export default {
  components: { LoadingInboxList },
  props: ["user"],
  data() {
    return {
      chatRooms: [],
      loading: false,
    };
  },

  created() {
    axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("token");
    this.fetchChatRooms();
  },

  computed: {
    activeChatRoomId() {
      const segments = new URL(window.location).pathname.split("/");
      return segments[2] || null;
    },
  },

  methods: {
    fetchChatRooms() {
      this.loading = true;
      axios
        .get("/api/chatrooms")
        .then((res) => {
          this.chatRooms = res.data;
          this.loading = false;
        })
        .catch((err) => {
          console.log("Error while receiving chatrooms.", err);
        });
    },
  },
};
</script>

<style scoped>
.new-message-label {
  color: green;
  animation: blink 1s step-start infinite;
}
@keyframes blink {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
}
</style>