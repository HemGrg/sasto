<template>
   <frontmaster>
    <!-- slider start -->
    <div class="slider-wrapper" v-scrollanimation style="min-height: 450px;">
      <div
        id="carouselExampleCaptions"
        class="carousel slide"
        data-ride="carousel"
      >
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="slider-overlay"></div>
            <img
              src="/images/vendorImages/slider (1).jpg"
              class="d-block w-100"
              alt="..."
            />
          </div>
          <div class="carousel-item">
            <div class="slider-overlay"></div>
            <img
              src="/images/vendorImages/slider (2).jpg"
              class="d-block w-100"
              alt="..."
            />
          </div>
          <div class="carousel-item">
            <div class="slider-overlay"></div>
            <img
              src="/images/vendorImages/slider (3).jpg"
              class="d-block w-100"
              alt="..."
            />
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-target="#carouselExampleCaptions"
          data-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-target="#carouselExampleCaptions"
          data-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </button>
      </div>

      <!-- content -->
      <div class="slider-content">
        <h1>Moving Into The Digital Era</h1>
        <p>
          Sastowholesale.com is the dynamic marketplace for Manufacturers,
          Wholesalers &amp; Traders: who are seeking to engage with more customers
          online, Sales lead or Business growth.
        </p>
        <a
          href="/vendor-register"
          class="btn btn-slider"
          >Start Selling</a
        >
        <div class="alert-login">
          <span>Already a Seller?</span>
        </div>
        <a href="/vendor-login" class="btn btn-slider login-bottom"
            >Login here</a>
      </div>
      <!-- content end -->

      <!-- feature -->
      <div class="feature">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-12">
              <div class="card border-0">
                <div class="card-body">
                  <i class="fas fa-phone-volume mr-2"></i>
                  <span>24 /7 Support</span>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-12">
              <div class="card border-0">
                <div class="card-body">
                  <i class="fas fa-envelope mr-2"></i>
                  <a href="mailto:vendor@sastowholesale.com" class="card-link">
                    vendor@sastowholesale.com
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- feature end -->
    </div>
    <!-- slider end -->

    <!-- why join sastowholsale start -->
    <section class="why-join animated zoomIn" v-scrollanimation>
      <div class="container">
        <!-- section heading start -->
        <div class="heading">
          <h2>Why Join Sastowholsale.com?</h2>
        </div>
        <div class="row mt-5">
          <div class="description" v-scrollanimation>
            <p>
              B2B, C2C Ecommerce is growing rapidly in Nepalese market. Most of
              the users are using online payment, doing online purchase these
              days. Internet user is growing every year. We have many B2B, B2C
              Ecommerce in Nepal, while we are going into a digital era, B2B
              Ecommerce is the future of Nepal. We believe in promoting B2B
              Ecommerce and making Digital Nepal. By registering in
              Sastowholesale.com you can reach more customers, more engagements
              &amp; more sales.
            </p>
          </div>
        </div>
        <div class="row mt-2" v-scrollanimation>
          <div class="secondary-heading" v-scrollanimation>
            <h4>Here are some of our benefits choosing Sastowholesale.com:</h4>
          </div>
          <div class="list mt-2" v-scrollanimation>
            <ul>
              <li>
                <i class="fa fa-check pt-1"></i>
                Sastowholesale.com is fully dedicated in promoting National and
                International products around the world.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i> Sastowholesale.com provides
                payment assurance to vendor and buyer.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i> Sastowholesale.com helps in
                providing Local &amp; International logistic Management and custom
                clearance management.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i> Sastowholesale.com provides
                different guidelines to vendor for exporting/importing goods to
                Nepal.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i>
                Registration is free for 1st year.
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- steps start -->
    <section class="step">
      <div class="container" v-scrollanimation>
        <!-- section heading start -->
        <div class="heading">
          <h2>SIX EASY STEPS TO SELL ON SASTOWHOLESALE.COM</h2>
        </div>
        <!-- section heading end -->

        <div class="row mt-5" v-scrollanimation>
          <div class="col-sm-12 col-md-6 col-lg-3 mx-auto step-1" v-scrollanimation>
            <div class="process-single-item">
              <div class="process-single-thumb">
                <i class="fas fa-user-plus"></i>
                <div class="process-number">
                  <span>01</span>
                </div>
              </div>
              <div class="process-content">
                <div class="process-content-title">
                  <h4>Register Now</h4>
                </div>
                <p>Click Register now and fill the form with your details.</p>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-3 mx-auto step-2" v-scrollanimation>
            <div class="process-single-item">
              <div class="process-single-thumb">
                <i class="fas fa-file-alt"></i>
                <div class="process-number">
                  <span>02</span>
                </div>
              </div>
              <div class="process-content">
                <div class="process-content-title">
                  <h4>Documents and Details</h4>
                </div>
                <p>Provide us the Business related documents &amp; Bank details</p>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-3 mx-auto step-3" v-scrollanimation>
            <div class="process-single-item">
              <div class="process-single-thumb">
                <i class="fas fa-check-circle"></i>
                <div class="process-number">
                  <span>03</span>
                </div>
              </div>
              <div class="process-content">
                <div class="process-content-title">
                  <h4>Get Verified</h4>
                </div>
                <p>You will get verified</p>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-3 mx-auto step-4" v-scrollanimation>
            <div class="process-single-item">
              <div class="process-single-thumb">
                <i class="fas fa-list"></i>
                <div class="process-number">
                  <span>04</span>
                </div>
              </div>
              <div class="process-content">
                <div class="process-content-title">
                  <h4>List Products</h4>
                </div>
                <p>List your products by providing their details</p>
              </div>
            </div>
          </div>
          <div data-v-cbdddaa2="" class="col-sm-12 col-md-6 col-lg-3 mx-auto step-4" v-scrollanimation>
            <div data-v-cbdddaa2="" class="process-single-item">
              <div data-v-cbdddaa2="" class="process-single-thumb">
                <i data-v-cbdddaa2="" class="fas fa-comments"></i>
                <div data-v-cbdddaa2="" class="process-number">
                  <span data-v-cbdddaa2="">05</span>
                </div>
              </div>
              <div data-v-cbdddaa2="" class="process-content">
                <div data-v-cbdddaa2="" class="process-content-title">
                  <h4 data-v-cbdddaa2="">Inquiries/messages</h4>
                </div>
                <p data-v-cbdddaa2="">
                  You need to reply to inquiries/messages
                </p>
              </div>
            </div>
          </div>
          <div data-v-cbdddaa2="" class="col-sm-12 col-md-6 col-lg-3 mx-auto step-6" v-scrollanimation>
            <div data-v-cbdddaa2="" class="process-single-item">
              <div data-v-cbdddaa2="" class="process-single-thumb">
                <i data-v-cbdddaa2="" class="fas fa-chart-line"></i>
                <div data-v-cbdddaa2="" class="process-number">
                  <span data-v-cbdddaa2="">06</span>
                </div>
              </div>
              <div data-v-cbdddaa2="" class="process-content">
                <div data-v-cbdddaa2="" class="process-content-title">
                  <h4 data-v-cbdddaa2="">Start Selling</h4>
                </div>
                <p data-v-cbdddaa2="">Protect your order &amp; payments</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
   </frontmaster>
</template>

<script>
export default {
  name: "LoginHomePage",
};
</script>

<style scoped>
@media only screen and (min-width: 992px) {
  .login-bottom{
  margin-bottom: 80px;
}
}

.card{
  min-height: 0px;
}
.description p,
.list, .secondary-heading {
  margin-left: 50px;
  margin-right: 50px;
  transition-delay: 0.4s;
}
.secondary-heading{
    color: #868585;
    font-weight: 400;
    text-transform: uppercase;
}
.list ul li {
  list-style: none;
}
.list i {
  color: #ffa500;
}
/*------------animation-------*/
@keyframes zoomIn {
  from {
    opacity: 0;
    -webkit-transform: scale3d(.3, .3, .3);
    transform: scale3d(.3, .3, .3);
  }

  50% {
    opacity: 1;
  }
}

.slider-wrapper, .why-join,.description,
 .step-1, .step-2, .step-3, .step-4, .step-5,
 .step-6, .secondary-heading, .list {
  opacity: 0;
}

.slider-wrapper
{
  animation-delay: 0.3s;
}
.why-join{
  animation-delay: 0.4s;
}
.description, .step-1, .secondary-heading,.list{
  animation-delay: 0.3s;
}
.step-2{
  animation-delay: 0.6s;
}
.step-3{
  animation-delay: 0.9s;
}
.step-4{
  animation-delay: 1s;
}
.step-5, .step-6{
  animation-delay: 1.2s;
}

.before-enter{
  opacity: 0;
   -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

.enter,.zoomIn{
  opacity: 1;
  -webkit-animation-name: zoomIn;
  animation-name: zoomIn;
}


</style>