<template>
  <div class="form-group">
        <label>{{label}}</label>
        <input
          :type="type"
          :placeholder="placeholder"
          title="Please enter you username"
        
          class="form-control"
        :v-bind="value"
        v-on:input="updateValue($event.target.value)"/>
        <!-- <span class="help-block small" style="color:red" v-if="!!error">{{error}}</span> -->
      </div>
</template>

<script>
export default {
    props:['label','type','value','placeholder'],
    methods: {
        updateValue(value){
            this.$emit("input", value)
        }
    }
}
</script>

<style>

</style>