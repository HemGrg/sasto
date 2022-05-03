<template>
  <div>
       <!-- header start -->
    <header data-v-cbdddaa2="" class="header position-sticky">
      <nav
        data-v-cbdddaa2=""
        class="navbar navbar-expand-lg navbar-light bg-light"
      >
        <div data-v-cbdddaa2="" class="container">
          <a data-v-cbdddaa2="" href="/" class="navbar-brand"
            ><img
              data-v-cbdddaa2=""
              src="/images/logo.png"
              alt="site logo"
              class="img-fluid site-logo"
          /></a>
          <button
            data-v-cbdddaa2=""
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            class="navbar-toggler"
          >
            <span data-v-cbdddaa2="" class="navbar-toggler-icon"></span>
          </button>
          <div
            data-v-cbdddaa2=""
            id="navbarSupportedContent"
            class="collapse navbar-collapse"
          >
            <ul data-v-cbdddaa2="" class="navbar-nav ml-auto">
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="/" class="nav-link">Home</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="javascript:void(0)" class="nav-link">Partners</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="#" class="nav-link">Blog</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="/faq" class="nav-link">FAQ</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="/vendor-register" class="nav-link">Register</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="/vendor-login" class="nav-link">Login</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- header end -->
  </div>
</template>

<script>
export default {
    name:"Header",

}
</script>

<style scoped>
.navbar-light .navbar-nav .active>.nav-link, .navbar-light .navbar-nav .nav-link.active, .navbar-light .navbar-nav .nav-link.show, .navbar-light .navbar-nav .show>.nav-link {
    color: rgb(29 117 189);
}
.navbar-light .navbar-nav .nav-link:hover {
   color: rgb(29 117 189);
    border-bottom: 1px solid  rgb(29 117 189);
}
.navbar-collapse{
  margin-top: 20px;
  margin-bottom: 10px;
  text-align: center;
  background-color: #e7ecf12e;
}
</style>