<template>
  <div class="message" v-bind:class="{ outgoing: isOutgoing(message), incomming: !isOutgoing(message) }">
    <file-block v-if="message.type == 'file'" :message="message"></file-block>
    <product-block v-else-if="message.type == 'product'" :message="message"></product-block>
    <text-block v-else :message="message"></text-block>
  </div>
</template>

<script>
import ProductBlock from './blocks/ProductBlock.vue';
import FileBlock from "./blocks/FileBlock.vue";
import TextBlock from "./blocks/TextBlock.vue";
export default {
  components: { ProductBlock, FileBlock, TextBlock },
  props: ["message", "user"],

  methods: {
    // check if is outgoing message
    isOutgoing(message) {
      if (!this.user) {
        return false;
      }
      return message.sender_id == this.user.id ? true : false;
    },
  },
};
</script>