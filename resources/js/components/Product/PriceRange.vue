<template>
  <div>
    <div class="ibox">
      <div class="ibox-head">
        <h5>Price Ranges</h5>
      </div>
      <div class="ibox-body">
        <div v-if="form.errors.any()">
          <div class="alert alert-danger">Please fix the errors and submit again.</div>
        </div>
        <div>
          <table class="table table-borderless">
            <tr>
              <td colspan="42">
                <div>You can also add price ranges to your products by clicking "Add Price Range" button.</div>
              </td>
            </tr>
            <tr v-for="(range, index) in form.ranges" class="table" :key="index">
              <td>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">From</span>
                  </div>
                  <input type="text" v-model="range.from" class="form-control" />
                </div>
                <div v-if="form.errors.has('ranges.' + index + '.from')">
                  <small class="text-danger">
                    {{ form.errors.first("ranges." + index + ".from") }}
                  </small>
                </div>
              </td>
              <td>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">To</span>
                  </div>
                  <input type="text" v-model="range.to" class="form-control" />
                </div>
                <div>
                  <small class="text-danger">
                    {{ form.errors.first("ranges." + index + ".to") }}
                  </small>
                </div>
              </td>
              <td>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Price</span>
                  </div>
                  <input type="text" v-model="range.price" class="form-control" />
                </div>
                <div>
                  <small class="text-danger">
                    {{ form.errors.first("ranges." + index + ".price") }}
                  </small>
                </div>
              </td>
              <td>
                <button type="button" @click="removeRange(index)" class="btn btn-danger btn-block border-0" title="remove field">Remove</button>
              </td>
            </tr>
            <tr>
              <td colspan="42">
                <button type="button" @click="addRange" class="btn btn-success border-0">Add Price Range</button>
              </td>
            </tr>
          </table>

          <div class="form-group px-2">
            <label class="mr-2">Price for purchase quantity without/above the range.</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rs. </span>
              </div>
              <input type="text" v-model="form.above_range_price" class="form-control" />
            </div>
            <div>
              <small class="text-danger">
                {{ form.errors.first("above_range_price") }}
              </small>
            </div>
          </div>
        </div>

        <div class="form-group d-flex mt-3">
          <div class="ml-auto">
            <button @click="submit" type="button" class="btn btn-primary btn-lg px-5 border-0">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "form-backend-validation";
import Swal from "sweetalert2";

export default {
  props: ["product"],

  created() {
    console.log(this.product.ranges);
    if (this.product.ranges && this.product.ranges.length) {
      this.product.ranges.forEach((range, index) => {
        if (range.to != null) {
          this.form.ranges.push({
            from: range.from,
            to: range.to,
            price: range.price,
          });
        }
      });

      this.form.above_range_price = this.product.above_range_price || null;
    }
  },

  data() {
    return {
      form: new Form(
        {
          ranges: [],
          above_range_price: "",
        },
        {
          resetOnSuccess: false,
        }
      ),
    };
  },

  methods: {
    addRange() {
      var lastRange = this.form.ranges[this.form.ranges.length - 1];
      let to = lastRange ? (parseInt(lastRange.to) || 0) + 1 : null;
      this.form.ranges.push({
        from: to,
        to: null,
        price: null,
      });
    },
    removeRange(index) {
      console.log("slicing at", index);
      this.form.ranges.splice(index, 1);
    },

    submit() {
      this.form.post("/product-pricing/" + this.product.id).then((response) => {
        console.log(response);
        Swal.fire({
          title: "Information Saved",
          text: "Price ranges have been saved successfully.",
          icon: "success",
          confirmButtonText: "Ok. Add Images Now",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = response.redirect_url;
          } else if (result.isDenied) {
            // alert('NOP');
          }
        });
      });
    },
  },
};
</script>