<template>
 <button :disabled="loading">
     <span class="d-inline-flex align-items-center">
        <div v-if="loading" class="spinner mr-2" />
        <slot />
     </span>
  </button>
</template>

<script>
export default {
    props: {
        loading: Boolean   
    }
}
</script>
<style scoped>
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.spinner {
    border: 0.2rem solid #f3f3f3;
    border-top: 0.2rem solid #1e76bd;
    border-radius: 50%;
    width: 1rem;
    height: 1rem;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}
</style>