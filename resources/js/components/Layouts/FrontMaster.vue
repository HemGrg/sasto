<template>
  <div>
    <Header/>
    <slot class="home"></slot>
    <Footer />
  </div>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
export default {
    name:'FrontMaster',
    components:{Header,Footer},
}
</script>

<style>

</style>