<template>
  <div>
    <!-- footer start -->
    <footer class="footer">
      <div class="container">
        <div class="row pt-row">
          <div class="col offset-md-1">
            <div class="pt-pl-list">
              <h3>About Us</h3>
              <ul>
                <li><a href="/about-us">About Sastowholesale.com</a></li>
                <li><a href="javascript:void(0)">Our Partners</a></li>
                <li><a href="/faq">Help Center</a></li>
                <li><a href="javascript:void(0)">Our Blogs</a></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="pt-pl-list">
              <h3>Sell on Sastowholesale.com</h3>
              <ul>
                <li><a href="/vendor-register">Become a Seller</a></li>
                <li><a href="/logistics-management">Logistics Management</a></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="pt-pl-list">
              <h3>Legal</h3>
              <ul>
                <li><a href="/terms-conditions" >Vendor Terms &amp; condition</a></li>
                <li><a href="/terms-of-use" >Terms of use</a></li>
                <li><a href="/privacy-policy">Privacy Policy</a></li>
              </ul>
            </div>
          </div>
        </div>
        <hr />
        <div class="bottom-footer">
          <p><b>©2022 Sasto Wholesale Pvt. Ltd. All rights Reserved.</b></p>
          <p>Email: vendor@sastowholesale.com</p>
          <p><b>Designed &amp; Developed By: Web House Nepal</b></p>
        </div>
        <hr />
      </div>
    </footer>
    <!-- footer end -->
  </div>
</template>

<script>
export default {
  name:'Footer',
};
</script>

<style scoped>
.pt-pl-list {
    padding: 15px 0px;
}
.pt-pl-list h3 {
    font-size: 16px;
    font-weight: 600;
}
.pt-pl-list ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
.pt-pl-list ul>li {
    line-height: 2rem;
}
.pt-pl-list a {
    color: #dddddd;
    font-size: 14px;
    transition: all ease 0.3s;
}
.pt-pl-list a:hover {
    color: #ffffff;
    transition: all ease 0.3s;
    padding-left: 5px;
    text-decoration: none;
}
@media (min-width: 320px) and (max-width: 768px){
  .pt-row .col {
      width: 100%;
      text-align: center;
      flex-basis: unset;
  }
}
</style>