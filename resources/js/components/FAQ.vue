<template>
  <frontmaster>
    <section class="faq">
      <div class="container">
        <div class="text-center heading">
          <h2>Frequently Asked Question</h2>
        </div>
        <br />
        <div class="faq-content" v-scrollanimation>
          <vue-faq-accordion :items="faqItems"></vue-faq-accordion>
        </div>
      </div>
    </section>
  </frontmaster>
</template>

<script>
import VueFaqAccordion from "vue-faq-accordion";
export default {
  name: "LoginHomePage",
  components: { VueFaqAccordion },
  props: ["faqs"],
  data() {
    return {
      faqItems: [
        {
          title: "",
          value: "",
        },
      ],
    };
  },
  mounted() {
    this.faqItems = this.faqs.map((el) => {
      return {
        title: el.title,
        value: el.description,
      };
    });
  },
};
</script>

<style scoped>
.faq-wrapper {
  max-width: 100px !important;
}
.before-enter {
  opacity: 0;
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

.enter,
.zoomIn {
  opacity: 1;
  -webkit-animation-name: zoomIn;
  animation-name: zoomIn;
}
.accordion__title {
  background-color: #f5f7f8 !important;
}
</style>