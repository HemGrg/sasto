<template>
  <div>
    <div v-if="loading">
      <h1>loading...</h1>
    </div>
    <form id="loginForm" @submit.prevent="onSubmit()">
      <login-inputs
        label="userName"
        type="email"
        placeholder="exampl@gamil.com"
        v-model="userName"
        :error="error.userName"
      ></login-inputs>
      <login-inputs
        label="Password"
        type="password"
        placeholder="Enter Password"
        v-model="password"
        :error="error.password"
      ></login-inputs>
      <div>
        <button class="btn-add">Login</button>
      </div>
    </form>
    <router-view></router-view>
  </div>
</template>

<script>
// import loginInput from './loginInput';
export default {
  // components: {loginInput},
  data() {
    return {
      userName: "",
      password: "",
      error: {},
      loading: false,
    };
  },
  methods: {
     onSubmit() {
      this.error = {};
      if (!this.userName.trim()) this.error.userName = "User name is required!";
      if (!this.password.trim()) this.error.password = "Password is required!";
      if (!!this.error) return;
      this.loading = false;
      setTimeout(() => {
        this.loading = false;
        this.$router.push("/");
      }, 3000);
    },
  },
};
</script>

<style>
</style>