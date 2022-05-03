<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 my-3">
          <nav>
            <a href="javascript:void(0)" @click="vendorHomepage">
              <img class="logo" src="/images/logo.png" alt="logo" />
            </a>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 m-auto login-row" style="padding: 30px 26px">
          <h4 class="text-center">User Info</h4>
          <form @submit.prevent="submitData">
            <div class="form-group">
              <label for="">Full Name</label>
              <input
                type="text"
                class="form-control"
                v-model="name"
                id=""
                aria-describedby=""
                placeholder="Enter Your Full Name"
              />
              <div class="text-danger">
                {{ validation_rule.getMessage("name") }}
              </div>
            </div>
            <div class="form-group">
              <label for="">Designation</label>
              <input
                type="text"
                class="form-control"
                v-model="designation"
                id=""
                aria-describedby=""
                placeholder="Enter Your Designation"
              />
              <div class="text-danger">
                {{ validation_rule.getMessage("designation") }}
              </div>
            </div>
            <div class="form-group">
              <label for="">Mobile Number</label>
              <input
                type="text"
                class="form-control"
                v-model="phone_num"
                id=""
                aria-describedby=""
                placeholder="Enter Your Mobile Number"
              />
              <div class="text-danger">
                {{ validation_rule.getMessage("phone_num") }}
              </div>
            </div>
            <div class="form-group">
              <label for="">Email address</label>
              <input
                type="email"
                class="form-control"
                v-model="email"
                id=""
                aria-describedby=""
                placeholder="email@example.com"
              />
              <div class="text-danger">
                {{ validation_rule.getMessage("email") }}
              </div>
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input
                v-if="showPassword"
                type="text"
                class="form-control"
                v-model="password"
                placeholder="Password"
              />
              <input
                v-else
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="password"
              />
              <span class="field-icon" @click="toggleShow" v-if="password">
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
              <div class="text-danger">
                {{ validation_rule.getMessage("password") }}
              </div>
            </div>
            <div class="form-group">
              <label for="">Confirm Password</label>
              <input
                v-if="showPassword"
                type="text"
                class="form-control"
                v-model="confirm_password"
                placeholder="Confirm Password"
              />
               <input
                v-else
                type="password"
                class="form-control"
                placeholder="Confirm Password"
                v-model="confirm_password"
              />
              <span class="field-icon" @click="toggleShow" v-if="password">
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
              <div class="text-danger">
                {{ validation_rule.getMessage("confirm_password") }}
              </div>
            </div>
            <div class="form-check mb-3">
              <input
                type="checkbox"
                class="form-check-input"
                v-model.trim="$v.terms.$model"
                :class="{ 'is-invalid': validationStatus($v.terms) }"
              />
              <label class="form-check-label" for=""
                >I accept all the terms and condition.<a href="/terms-conditions" target="_blank"><span style="color: #007bff;">Read here.</span></a></label
              >
            </div>
            <div class="form-check mb-3">
              <p>
                Note: For verification please provide business related document
                to us through mail.
              </p>
            </div>
            <div class="text-center">
              <loading-button
                type="submit"
                class="btn btn-primary mt-4"
                :loading="loading"
                >{{ loading ? "Please wait" : "Save Changes" }}</loading-button
              >
            </div>
          </form>
        </div>
        <!-- col-md-12 closing -->
      </div>
    </div>
    <!-- /.register-box -->
  </div>
</template>

<script>
import axios from "axios";
import validation from "./../../services/validation";
import swal from "sweetalert";
import { sameAs } from "vuelidate/lib/validators";
import LoadingButton from "../LoadingButton.vue";

export default {
  props: ["vendorinfo"],
  name: "registor",
  components: { LoadingButton },
  data() {
    return {
      validation_rule: new validation(),
      name: "",
      email: "",
      designation: "",
      phone_num: "",
      password: "",
      confirm_password: "",
      terms: false,
      loading: false,
      showPassword:false,
      errors: {},
    };
  },
  validations: {
    terms: {
      sameAs: sameAs(() => true),
    },
  },
  methods: {
    validationStatus: function (validation) {
      return typeof validation != "undefined" ? validation.$error : false;
    },
    toggleShow() {
      this.showPassword = !this.showPassword;
    },
    vendorHomepage() {
      window.location.href = "/vendor-homepage";
    },
    async submitData() {
      this.$v.$touch();
      if (this.$v.$pendding || this.$v.$error) return;
      this.loading = true;
      try {
        const response = await axios.post("api/vendor/register", {
          name: this.name,
          email: this.email,
          designation: this.designation,
          phone_num: this.phone_num,
          password: this.password,
          confirm_password: this.confirm_password,
          category: this.vendorinfo.categoryinfo.mainSeller,
          plan: this.vendorinfo.categoryinfo.category,
          shop_name: this.vendorinfo.shop_name,
          company_address: this.vendorinfo.company_address,
          country_id: this.vendorinfo.country_id,
          company_email: this.vendorinfo.company_email,
          company_phone: this.vendorinfo.company_phone,
          business_type: this.vendorinfo.business_type,
          category_id: this.vendorinfo.category_id,
        });
        if (response.status === 200) {
          this.loading = false;
          swal("Done!", "Your are registered!", "success");
          window.location.href = "/account-verification";
        }
      } catch (error) {
        if (error.response.status === 422) {
          this.loading = false;
          this.errors = error.response.data;
          this.validation_rule.setMessages(this.errors.errors);
        } else {
          this.loading = false;
          alert("Something went wrong please try again.");
        }
      }
    },
  },
};
</script>

<style>
</style>