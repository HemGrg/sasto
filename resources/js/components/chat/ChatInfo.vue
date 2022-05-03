<template>
  <div v-if="show" class="information-modal border-left shadow">
    <div class="content py-4 px-5">
      <div v-if="user">
        <div class="text-center mb-4">
          <img :src="user.avatar_url" style="height: 200px; width: 200px; background-position: cover" />
        </div>
        <div class="text-center">
          <h4 class="h4-responsive">{{ user.name }}</h4>
          <!-- <div>Phone: {{ user.phone }}</div> -->
          <div>Email: {{ user.email }}</div>
          <div>Address: {{ user.address }}</div>
        </div>
      </div>
      <div v-else class="py-5">
        Please wait...
      </div>
      <div class="text- p-2"><button type="button" class="btn btn-primary btn-block" @click="hideChatInfo">Close</button></div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["chatRoom"],
  data() {
    return {
      show: false,
      user: null,
    };
  },

  mounted() {
    window.addEventListener("show-chat-info", (e) => {
      this.show = true;
    });
  },

  methods: {
    loadUser() {
      axios.get(`/api/chat-customer-info/${this.chatRoom.customer_user_id}`).then((response) => {
        this.user = response.data;
      });
    },

    hideChatInfo() {
      this.show = false;
    },
  },

  watch: {
    show() {
      if (!this.user) {
        this.loadUser();
      }
    },
  },
};
</script>

<style scoped>
.information-modal {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 999;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(204, 204, 204, 0.4);
  /* right: 0;
  height: 100vh;
  background-color: #fff; */
}

.information-modal .content {
  background-color: #fff;
  border-radius: 4px;
}
</style>