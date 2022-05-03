<template>
  <div>
    <section class="login-main">
      <div class="container">
        <div class="login-form-card">
          <div class="card login-card border-0">
            <div class="card-body">
              <div class="text-center">
                <a href="/" class="router-link-active">
                  <img src="/images/logo.png" alt="logo" class="logo-img" />
                </a>
              </div>
              <div class="row">
                <div class="col-12">
                  <h4 class="login-title">
                    Welcome To <span>Seller Market</span>
                  </h4>
                </div>
                <div class="col-12">
                  <form @submit.prevent="onSubmit()">
                    <error v-if="error" :error="error" />
                    <Input
                      label="Email"
                      type="text"
                      placeholder="example@gmail.com"
                      v-model="email"
                    />
                    <div class="form-group">
                      <label for="">
                        Password
                        <span class="pt-fp"
                          ><a
                            href="javascript:void(0)"
                            class=""
                            tabindex="-1"
                            @click="onClickForgot"
                            >Forgot Password?</a
                          ></span
                        >
                      </label>
                      <input
                        v-if="showPassword"
                        type="text"
                        class="form-control"
                        placeholder="Enter Password"
                        v-model="password"
                      />
                      <input
                        v-else
                        type="password"
                        class="form-control"
                        placeholder="Enter Password"
                        v-model="password"
                      />
                      <span
                        class="field-icon icon-cl"
                        @click="toggleShow"
                        v-if="password"
                      >
                        <span class="icon is-small is-right">
                          <i
                            class="fa"
                            :class="{
                              'fa-eye-slash': showPassword,
                              'fa-eye': !showPassword,
                            }"
                          ></i>
                        </span>
                      </span>
                    </div>
                    <div class="form-check pl-0">
                      <input
                        type="checkbox"
                        style="position: absolute; margin-top: 0.3rem;"
                        id="rememberMe"
                        v-model="remember_me"
                      />
                      <label class="form-check-label ml-3" for="rememberMe"
                        >Remember Me</label
                      >
                    </div>
                    <loading-button
                      type="submit"
                      class="btn btn-primary"
                      :loading="loading"
                      >{{ loading ? "Please wait" : "Sign In" }}</loading-button
                    >
                    <p class="signup">
                      New around here?
                      <a href="javascript:void(0)" @click="onClickSingup">
                        Sign Up</a
                      >
                    </p>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="copyright">
            <p>
              Copyright &copy; 2022
              <a href="javascript:void(0)" @click="vendorHomepage"
                >Sasto Wholesale</a
              >
              All Rights Reserved
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Input from "../vendorLogin/Input.vue";
import axios from "axios";
import error from "../vendorLogin/Error.vue";
import validation from "./../../services/validation";
import LoadingButton from "../LoadingButton.vue";

export default {
  name: "login",
  components: { Input, error, LoadingButton },
  data() {
    return {
      validation: new validation(),
      email: "",
      password: "",
      remember_me: false,
      loading: false,
      showPassword: false,
      error: "",
    };
  },
  methods: {
    vendorHomepage() {
      window.location.href = "/vendor-homepage";
    },
    toggleShow() {
      this.showPassword = !this.showPassword;
    },
    async onSubmit() {
      this.error = "";
      this.loading = true;
      try {
        const response = await axios.post("/vendor/login", {
          email: this.email,
          password: this.password,
          remember: this.remember_me,
        });
        if (response.status === 200) {
          localStorage.setItem("token", response.data.token);
          this.loading = false;
          window.location.href = "/dashboard";
        }
      } catch (e) {
        if (e.response.status === 400) {
          this.loading = false;
          this.error = e.response.data.message;
          this.validation.setMessages(this.error);
        } else if (e.response.status === 422) {
          this.loading = false;
          this.error = "Please fill both Email & Password.";
          this.validation.setMessages(this.error);
        } else {
          this.loading = false;
          this.error = "Invalid email/password!";
        }
      }
    },
    onClickSingup() {
      window.location.href = "/vendor-register";
    },
    onClickForgot() {
      window.location.href = "/forgot-password";
    },
  },
};
</script>
 
<style>
.login-main {
  position: relative;
}

.login-form-card {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 450px;
}

.logo {
  height: 80px;
}
.vendor-bg {
  background: url("/images/pexels-photo-5668841.jpeg") no-repeat;
  background-size: cover;
  background-position: center center;
}

.vendor-overlay {
  padding: 104px 0;
  background-color: rgba(0, 0, 0, 0.3);
}

.vendor-title {
  color: #ffffff;
  font-size: 2.8rem;
  font-weight: 500;
  line-height: 1.5;
}

.vendor-sign-in-form,
.vendor-section {
  background: #f2f3f7;
}

.vendor-btn {
  margin-bottom: 2rem;
}

.vendor-form {
  padding: 18px 20px;
  border: 1px solid lightgray;
}

.vendor-form-bt {
  padding: 18px 20px;
  border: 1px solid lightgray;
}
.form-check {
  margin-bottom: 1rem;
}

/*************** Steps ****************/
.step-div {
  display: inline-block;
  width: 200px;
  padding: 12px;
  background: #ffffff;
  box-shadow: 1px 1px 6px 0px lightblue;
}

.step-group {
  display: flex;
  justify-content: space-around;
}

.step-subtitle {
  color: #ffa500;
  font-size: 1.2rem;
  font-weight: 500;
}

.step-div-h1 {
  color: #1e76bd;
}

.step-div-p {
  font-weight: 500;
}

.vendor-img-wrap {
  margin: 1.4rem 0;
}

@media screen and (max-width: 600px) {
  .step-group {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .step-div:not(:last-child) {
    margin-bottom: 1.8rem;
  }
  
  .login-form-card {
    width: 90%;
  }
}

.field-icon {
  float: right;
  margin-right: 10px;
  margin-top: -30px;
  position: relative;
  z-index: 2;
  cursor: pointer;
}

/* new */
.login-main {
  background-image: linear-gradient(
      to bottom,
      rgba(0, 0, 0, 0.3),
      rgba(0, 183, 255, 0.3)
    ),
    url("/images/pexels-photo-5668841.jpeg");
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  position: relative;
  background-position: center;
  min-height: 100vh;
  padding: 50px 0px;
}

.login-title {
  text-align: center;
  font-size: 24px;
  color: #252829;
  font-weight: 600;
  text-transform: uppercase;
  margin: 10px 0 20px 0;
}

.login-title span {
  color: #fc0001;
}

.login-card {
  border-radius: 5px !important;
}

.login-card label {
  font-size: 14px;
}

.login-card .btn {
  cursor: pointer;
  display: block;
  width: 100%;
  margin-bottom: 15px;

  padding: 10px 0;
  font-size: 16px;
  border-radius: 35px;
  -webkit-border-radius: 35px;
  -moz-border-radius: 35px;
  -ms-border-radius: 35px;
  -o-border-radius: 35px;
}

.login-card .btn-primary {
  background-color: #1d75bd;
}

.login-span {
  color: #757575;
  font-size: 13px;
}

.third-party-login {
  margin-top: 10px;
}

.login-card .btn-facebook {
  color: #fff;
  background-color: #3b5998;
}

.login-card:hover {
  box-shadow: 0 0 0 0 #fff !important;
}

.btn-google {
  color: #fff;
  background-color: #d34836;
}

.link-forget {
  margin: 15px 0;
  text-align: center;
}

.link-forget a {
  font-size: 14px;
  color: #1e76bd;
}

.signup {
  font-size: 14px;
  text-align: center;
}

.signup a{
  color: #1e76bd;
}

.pt-login-nav {
  padding: 15px 0px;
  background-color: #fff;
}

.logo-img {
  height: 55px;
  margin-bottom: 20px;
}

.copyright {
  text-align: center;
  padding: 20px 0;
  color: #fff;
}

.copyright p a {
  color: #fff;
  text-decoration: underline;
}

/* .copyright p a:hover {
  color: #1e76bd;
} */

.pt-fp {
  position: absolute;
  right: 30px;
  font-size: 14px;
  color: #1e76bd;
}

.icon-cl i {
  color: #535758;
  font-size: 14px;
}
</style>