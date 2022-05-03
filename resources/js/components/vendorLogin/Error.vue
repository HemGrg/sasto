<template>
  <div>
      <div class="alert alert-danger alert-dismissible" id="errorMessage">
    {{error}}
</div>
  </div>
</template>

<script>
export default {
    name:'Error',
    props:['error']

}

</script>

<style>

</style>