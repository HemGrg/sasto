<template>
       <div class="form-group">
            <label>{{label}}</label>
            <input :type="type" class="form-control" placeholder="Enter Admin Name" name="admin_name" id="admin_name" 
            :v-bind="value" v-on:input="$emit('input', $event.target.value)">
        </div>
</template>

<script>
export default {
    props:['label','type','value'],
}
</script>

<style>

</style>