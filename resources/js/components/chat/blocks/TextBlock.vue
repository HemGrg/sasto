<template>
  <div class="text-block" v-html="message.message"></div>
</template>

<script>
export default {
  props: ["message"],
};
</script>

<style scoped>
.message .text-block {
  padding: 10px 15px;
  border-radius: 1rem;
}
.message.outgoing .text-block {
  border-bottom-right-radius: 2px;
  background-color: #f5f5f5;
  color: #333;
}
.message.incomming .text-block {
  border-bottom-left-radius: 2px;
  background-color: #2196f3;
  color: #fefefe;
}

.message .date-time {
  font-size: 0.8rem;
  font-weight: 500;
}
.message.incomming .date-time {
  color: #fafaff;
}
.message.outgoing .date-time {
  color: darkgray;
}
</style>