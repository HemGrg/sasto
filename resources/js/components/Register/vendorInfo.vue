<template>
  <div>
    <!-- <button @click="visibility" v-show="visible">Back</button> -->
    <div class="general-information" v-show="visible">
      <div class="container">
        <div class="row">
          <div class="row">
        <div class="col-md-12 my-3">
          <nav>
            <a href="javascript:void(0)" @click="vendorHomepage">
              <img class="logo" src="/images/logo.png" alt="logo" />
            </a>
          </nav>
        </div>
      </div>
        </div>
        <div class="row general-row">
          <div class="col-md-12 mb-4">
            <h3 class="general-title text-center">
              Vendor Details Information
            </h3>
            <form @submit.prevent="onclick">
              <div class="col-md-12 mb-4">
                <h4 class="text-center general-subtitle">
                  General Information
                </h4>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="inputShop">Shop/Company Name</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      id="inputShop"
                      v-model.trim="$v.shop_name.$model"
                      :class="{ 'is-invalid': validationStatus($v.shop_name) }"
                      placeholder=""
                    />
                    <div v-if="!$v.shop_name.required" class="invalid-feedback">
                      Required.
                    </div>
                  </div>
                   <div class="form-group col-md-6">
                    <label for="inputShop">Company Address</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      id="inputShop"
                      v-model.trim="$v.company_address.$model"
                      :class="{ 'is-invalid': validationStatus($v.company_address) }"
                      placeholder=""
                    />
                    <div v-if="!$v.company_address.required" class="invalid-feedback">
                      Required.
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Company Phone</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                       v-model.trim="$v.company_phone.$model"
                      :class="{ 'is-invalid': validationStatus($v.company_phone) }"
                      placeholder="Enter company contact number"
                    />
                    <div
                      v-if="!$v.company_phone.required"
                      class="invalid-feedback"
                    >
                      Required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Company Email</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                       v-model.trim="$v.company_email.$model"
                      :class="{ 'is-invalid': validationStatus($v.company_email) }"
                      placeholder="Enter your Company Email"
                    />
                    <div
                      v-if="!$v.company_email.required"
                      class="invalid-feedback"
                    >
                      Required.
                    </div>
                    <div
                      v-if="!$v.company_email.email"
                      class="invalid-feedback"
                    >
                      Email must be valied email.
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Business Type</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <select class="form-control" v-model.trim="$v.business_type.$model"
                     :class="{ 'is-invalid': validationStatus($v.business_type) }">
                     <option v-for="(business_type,index) in business_types" 
                      :key="index" :value="business_type">{{business_type}}</option>
                    </select>
                    <div
                      v-if="!$v.business_type.required"
                      class="invalid-feedback"
                     >
                      Required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Country</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <select class="form-control" v-model.trim="$v.country_id.$model"
                     :class="{ 'is-invalid': validationStatus($v.country_id) }">
                     <option value="" disabled>Select Country</option>
                      <option v-for="(country,index) in countries" 
                      :key="index" :value="country.id">{{country.name}}</option>
                    </select>
                    <div
                      v-if="!$v.country_id.required"
                      class="invalid-feedback"
                    >
                      Required.
                    </div>
                  </div>
                </div>

                 <div class="row">
                  <div class="form-group col-md-12">
                    <label for="">What kind of product do yo sell ?</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <multiselect v-model.trim="$v.value.$model" :options="options"
                    :class="{ 'is-invalid': validationStatus($v.value) }"
                    :multiple="true" placeholder="Type to search"
                    track-by="name" :hide-selected="true" label="name">
                    <span slot="noResult">Oops! No category found. Consider changing the search query.</span>
                    </multiselect>
                    <div
                      v-if="!$v.value.required"
                      class="invalid-feedback"
                    >
                      Required.
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12 text-center">
                <button class="btn btn-primary custom-submit-btn">Next</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-show="!visible">
      <VendorSave :vendorinfo="vendorinfo" :visibility3="visibility3" />
    </div>
  </div>
</template>

<script>
import VendorSave from "./registerVendor.vue";
import { required, email} from "vuelidate/lib/validators";
import Multiselect from "vue-multiselect";
import axios from "axios";

export default {
  props: ["categoryinfo", "visibility2","countries", "business_types"],
  name: "VendorInfo",
  components: { VendorSave, Multiselect},
  data() {
    return {
      visible: true,
      vendorinfo: {},
      shop_name: "",
      company_address:'',
      company_phone:'',
      company_email:'',
      business_type:'',
      country_id:'',
      options: [],
      value: [],
      category_id:{},
    };
  },
  validations: {
    shop_name: { required},
    company_address: {required},
    company_email: {required, email},
    company_phone:{required},
    business_type:{required},
    country_id:{required},
    value:{required},
  },

  mounted(){
     axios
      .get('/api/vendor-category')
      .then(response => (this.options = response.data));
  },

  methods: {
     validationStatus: function (validation) {
      return typeof validation != "undefined" ? validation.$error : false;
    },
  
    onclick() {
      this.$v.$touch();
      if (this.$v.$pendding || this.$v.$error) return;
      this.vendorinfo = {
        categoryinfo: this.categoryinfo,
        shop_name: this.shop_name,
        company_address: this.company_address,
        company_email: this.company_email,
        company_phone: this.company_phone,
        business_type: this.business_type,
        country_id: this.country_id,
        category_id: this.value.map(element =>{
          return element.id
        })
      };
      this.visible = false;
    },
    visibility() {
      this.visibility2();
    },
    visibility3() {
      this.visible = !this.visible;
    },
     vendorHomepage(){
        window.location.href = "/vendor-homepage";
    },
  },
};
</script>

<style>
</style>