<template>
  <div>
    <!-- <button @click="visibility" v-show="visible">Back</button> -->
      <div class="select-plan-body" v-show="visible">
          <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="select-title-wrapper">
              <h3 class="text-center text-uppercase my-4 select-title">
                Select Plan
              </h3>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="card-deck">
              <div class="col-sm-4">
                  <div class="card text-center mb-4" style=" border-radius: 2.25rem; margin: 0;">
                    <div class="img-wrapper">
                      <img
                        class="card-img-top"
                        src="/images/photo-1579621970563-ebec7560ff3e.jpg"
                        alt="card image cap"
                      />
                    </div>
                    <div class="card-body">
                      <h3 class="card-head">Basic Plan</h3>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Post unlimited products </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Receive & response to inquires </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Response to RFQ’s</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Sub accounts</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Business verification </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          Support via email & chat 
                        </p>
                      </div>
                    </div>
                    <div class="card-footers">
                      <button
                        class="btn btn-primary btn-select"
                       value="basic_plan" @click="onclick"
                      >
                        Select
                      </button>
                    </div>
                  </div>
              </div>
                <div class="col-sm-4">
                  <div class="card text-center mb-4"  style=" border-radius: 2.25rem; margin: 0;">
                    <div class="img-wrapper">
                      <img
                        class="card-img-top"
                        src="/images/photo-1579621970563-ebec7560ff3e.jpg"
                        alt="card image cap"
                      />
                    </div>
                    <div class="card-body">
                      <h3 class="card-head">Standard Plan</h3>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Post unlimited products </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Receive & response to inquires </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Response to RFQ’s</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Sub accounts</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Business verification </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Support via email, phone & chat </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          Listing in Sastowholesale Mall
                        </p>
                      </div>
                    </div>
                    <div class="card-footers">
                      <button
                        class="btn btn-primary btn-select"
                        value="standard_plan" @click="onclick"
                      >
                        Select
                      </button>
                    </div>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="card text-center mb-4"  style=" border-radius: 2.25rem; margin: 0;">
                    <div class="img-wrapper">
                      <img
                        class="card-img-top"
                        src="/images/photo-1579621970563-ebec7560ff3e.jpg"
                        alt="card image cap"
                      />
                    </div>
                    <div class="card-body">
                      <h3 class="card-head">Premium Plan</h3>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Post unlimited products</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Receive & response to inquires </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Response to RFQ’s</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Sub accounts</p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Business verification </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Support via email, phone & chat </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">Market research </p>
                      </div>
                      <div class="list-item">
                        <i class="fa fa-check pt-1"></i>
                        <p class="pl-2 text-left">
                          Guide to export products 
                        </p>
                      </div>
                    </div>
                    <div class="card-footers">
                      <button
                        class="btn btn-primary btn-select"
                        value="premium_plan" @click="onclick"
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
       <div v-show="!visible"><VendorInfo :categoryinfo = "categoryinfo" :visibility2 = "visibility2" :countries="countries" :business_types="business_types"/></div>
  </div>
</template>

<script>
import VendorInfo from './vendorInfo.vue'
export default {
  props: ['mainSeller', 'visibility1', "countries", "business_types"],
  name:'SelectPlan',
  components: {VendorInfo},
  data(){
    return{
      visible: true,
      categoryinfo: {},
      category: ''

    }
  },
  methods:{
    onclick(e){
      // console.log(this.mainSeller)
      this.categoryinfo = {
        mainSeller : this.mainSeller,
        category : e.target.value,
      }
      this.visible = false
    },
    visibility(){
      this.visibility1()
    },
    visibility2(){
            this.visible = !this.visible
        }
  }
}
</script>