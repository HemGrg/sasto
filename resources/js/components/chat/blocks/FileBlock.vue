<template>
  <div>
    <div v-if="message.is_image" class="image-block">
      <img :src="message.file_url" />
    </div>
    <div v-else class="file-block text-dark d-flex">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" style="height: 50px; width: 50px; color: #ffc60b" viewBox="0 0 20 20" fill="currentColor">
          <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
        </svg>
      </div>
      <div class="pl-3">
        <div class="text-lg font-semibold">File</div>
        <a class="btn btn-link px-0 text-sm" :href="message.file_url" download target="_blank">Download</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["message"],
};
</script>

<style scoped>
.message .image-block {
  /* max-width: 300px; */
  border-radius: 0.25rem;
}
.message .image-block img {
  height: 200px;
  width: auto;
  border-radius: 0.25rem;
}
.message .file-block {
  border: 1px solid #efefef;
  padding: 10px 15px;
  border-radius: 0.5rem;
  background-color: #f8f9fa;
  color: #333;
}
</style>