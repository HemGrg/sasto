<template>
   <form id="validateForm" @submit.prevent="saveProduct" enctype="multipart/form-data" novalidate>
        <div class="form-group col-sm-8">
                        <label>Category Name</label>
                        <input type="text" class="form-control" placeholder="Enter Category Name" name="name" id="name">
                     </div>
                     <div class="form-group col-sm-3">
                        <label>Upload Category Image</label>
                        <input type="file" name="image" id="fileUpload" class="form-control">
                        <div id="wrapper" class="mt-2">
                           <div id="image-holder">
                           </div>
                        </div>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Is Featured Category ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                              <input type="checkbox" id="featured" name="featured" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                        <label class="col-lg-6">
                           <span class="alert-warning">
                              *Remembar: This will allow to display in 'Best Our Collections Section
                              in homepage.'
                           </span>
                        </label>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Include in the menu ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                               <input type="checkbox" id="in_include" name="in_include" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                        <label class="col-lg-6">
                           <span class="alert-warning">*Remembar:Don't tick on this
                              menu if this is not a Top Menu Category.</span>
                        </label>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Does Contains Sub-category ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                              <input type="checkbox" id="is_sub_category" name="is_sub_category" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Publish ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                              <input type="checkbox" id="publish" name="publish" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                     </div>
                     <div class="reset-button col-sm-12">
                        <input type="submit" class="btn btn-success" value="Add Category">
                     </div>
                  </form>
</template>

<script>
export default {
    async created(){
        const res = await this.callApi('post','/add-product',{tagName: 'testTag'});
         console.log(res)
        if(res.status == 200){
           
        }
    }
}
</script>

<style>

</style>