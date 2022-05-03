<template>
  <div>
    <div class="category-body" v-show="visible">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="select-title-wrapper">
              <h3 class="text-center text-uppercase my-4 select-title">
                Select Category
              </h3>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="card-deck">
              <div class="col-sm-6">
                <div class="custom-card">
                  <div class="card text-center mb-4" style=" border-radius: 2.25rem; margin: 0;">
                    <div class="img-wrapper">
                      <img
                        class="card-img-top"
                        src="/images/photo-1579621970563-ebec7560ff3e.jpg"
                        alt="card image cap"
                      />
                    </div>
                    <div class="card-body">
                      <h3 class="card-head">Local Seller</h3>
                      <p class="card-text">
                        Sastowholesale.com offers Local seller to reach
                        wide range of customers nationwide with different seller tools.
                      </p>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">You can sell Product/service nationwide</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          Access to wide array of seller tools
                        </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          You can receive Nepali currency
                        </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          No registration fees
                        </p>
                      </div>
                    </div>
                    <div class="card-footers">
                      <button
                        class="btn btn-primary btn-select"
                        value="local_seller"
                        @click="onclick"
                      >
                        Select
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="custom-card">
                  <div class="card text-center mb-4"  style=" border-radius: 2.25rem; margin: 0;">
                    <div class="img-wrapper">
                      <img
                        class="card-img-top"
                        src="/images/photo-1579621970563-ebec7560ff3e.jpg"
                        alt="card image cap"
                      />
                    </div>
                    <div class="card-body">
                      <h3 class="card-head">International Seller</h3>
                      <p class="card-text">
                        Sastowholesale.com offers international seller to reach
                        wide range of customers globally 
                      </p>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">You can sell product/service globally</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          No registration Fees
                        </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          You are a registered business
                        </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          You can receive currency in your local currency & USD too
                        </p>
                      </div>
                    </div>
                    <div class="card-footers">
                      <button
                        class="btn btn-primary btn-select"
                        value="international_seller"
                        @click="onclick"
                      >
                        Select
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Task 2 Completed-->
    </div>
    <div class="category" v-show="!visible">
      <Plan :mainSeller="mainSeller" :visibility1="visibility1" :countries="countries" :business_types="business_types"/>
    </div>
  </div>
</template>

<script>
import Plan from "./selectPlan.vue";
export default {
  name: "SelectCategory",
  components: { Plan },
  props:["countries", "business_types"],
  data() {
    return {
      visible: true,
      mainSeller: "",
    };
  },
  methods: {
    onclick(e) {
      this.mainSeller = e.target.value;
      this.visible = false;
    },
    visibility1() {
      this.visible = !this.visible;
    },
  },
};
</script>

<style>
.card{
  min-height: 520px;
}
.category-body {
    background: #F2F3F7;
}
/********************  Image   ********************/
.img-wrapper {
    height: 120px;
    width: 120px;
    margin: 0 auto;
}

.img-wrapper > img {
    height: inherit;
    width: inherit;
    object-fit: cover;
    border-radius: 50%;
}

/********************  card   ********************/

.card-footers {
    padding: .10rem 1.25rem;
    border-top: none;
    background: none;
}
.card-footers button{
    border-radius: 2.25rem;
}

/********************  Button Category   ********************/
*:focus {
    box-shadow: none!important;
}

.btn-category {
    font-weight: 500;
    color: #FFFFFF;
    background: #FFA500;
    border: 1px solid #FFA500;
    width: 250px;
    margin: 0 auto;
}

.btn-category:hover{
    color: #FFFFFF;
    background: rgb(240, 156, 0);
    border: 1px solid rgb(240, 156, 0);
}

/********************  Button Select   ********************/
.btn-select {
    height: 40px;
    width: 100%;
    margin: 0 auto;
    font-weight: 500;
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.btn-select:hover {
    color: #1e76bd;
    background: #FFFFFF;
}

.card:hover {
    transition: all .4s ease-in;
    box-shadow: 2px 1px 7px 0px #1e76bd; /* 6px 1px */
}

/********************  Button Category Plan   ********************/
.list-item {
    display: flex;
    justify-content: flex-start;
    margin: 0 18px;
}
.list-item  > p {
    margin: 0;
}

.list-item > i {
    color: #FFA500;
}

/********************  Media Queries   ********************/
@media all and (max-width: 960px) {
    .card-deck {
        flex-direction: column;
    }

    .card-deck .card{
        margin-right: 30px;
        margin-left: 30px;
    }
}

.select-plan-body {
    background: #F2F3F7;
}
.select-title-wrapper {
    margin-bottom: 2.8rem;
}
.select-title {
    color: #FFFFFF;
    font-size: 1.4rem;
    padding: 10px 0;
    background: #737372;
}

/********************  Image   ********************/
.img-wrapper {
    height: 120px;
    width: 120px;
    margin: 0 auto;
}

.img-wrapper > img {
    height: inherit;
    width: inherit;
    object-fit: cover;
    border-radius: 50%;
}

/********************  card   ********************/
.card {
    border-radius: 2.25rem;
}

.card-deck .card{
    padding: 20px 25px;
}

.card-footer {
    border-top: none;
    background-color: #FFFFFF;
}

/********************  Button Category  ********************/
.btn-category {
    font-weight: 500;
    color: #FFFFFF;
    background: #FFA500;
    border: 1px solid #FFA500;
    width: 250px;
    margin: 0 auto;
}

.btn-category:hover{
    color: #FFFFFF;
    background: rgb(240, 156, 0);
    border: 1px solid rgb(240, 156, 0);
}
/********************  Button Select  ********************/
.btn-select { 
    height: 34px;
    /* width: 96px;  */
    width: 100%;
    margin: 0 auto;
    border-radius: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/********************  Media Queries   ********************/
@media all and (min-width: 960px) {
  .custom-card{
     padding: 20px 0px;
     margin-right: 60px;
     margin-left: 60px;
  }
}



/**************************  general information.html  ***************************/
/********************************************************************************/
.general-information {
    background: #FFFFFF;
}
.general-row {
    border: 1px solid lightgray;
    border-radius: 35px;
    padding: 26px 10px;
    background: #F2F3F7;
}

.general-title {
    font-size: 1.4rem;
    font-weight: bolder;
}

.general-subtitle {
    color: #f37b34;
    font-size: 1.2rem;
    margin-bottom: 1.4rem;
}

.general-label {
    font-size: 1rem;
}

.general-row label {
    color: #595d64;
    font-weight: 500;
}

.custom-submit-btn {
    width: 200px;;
}

.logo {
    height: 80px;
}

.fa-asterisk {
    color:#f37b34;
}

.img-asterik {
    margin-bottom: 6px;
}

/**************************  login.html  ***************************/
/**********************************************************************/
.login-row {
    border: 1px solid lightgray;
    /* padding: 30px 18px; */
    border-radius: 20px;
    background: #F2F3F7;
}

.btn-signup {
    width: 126px;
    border-radius: 20px;
}

/***************************** otp form *******************************/
.otp-form-wrapper {
    /* margin: 0 auto; */
    padding: 40px;
    box-shadow: 1px 1px 6px 0px lightblue;
    background: #F2F3F7;
}

.otp-verification-status {
    padding: 16px 30px;
    color: #3a6449;
    background: #d4edda;
    border-radius: 4px;
}

.otp-form  input {
    margin-bottom: 1rem;
}

.otp-btn {
    width: 100%;
}

</style>