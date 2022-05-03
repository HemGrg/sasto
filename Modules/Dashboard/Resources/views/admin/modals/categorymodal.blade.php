<div class="modal fade" id="categoryModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Product category</h4>
        </div>
        <div class="modal-body">
          <form id="create-category-form">
          <div class="form-group ">
              <label class="col-sm-8">Category Name</label>
              <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Enter name">
            </div>

            <div class="row form-group">
              <label for="" class="col-sm-6">Is Featured Category ? :</label>
              <div class="col-sm-1">
                  <label class="ui-checkbox ui-checkbox-warning">
                      <input type="checkbox" name="is_featured"  id="is_featured"
                          >
                      <span class="input-span"></span>Yes
                  </label>
              </div>
              <!-- <label class="col-lg-8">
                  <span class="alert-warning">
                      *Remember: This will allow to display in 'Best Our Collections Section
                      in homepage.'
                  </span>
              </label> -->
          </div>


          <div class="row form-group">
              <label for="" class="col-sm-6">Include In Main Menu:</label>
              <div class="col-sm-1">
                  <label class="ui-checkbox ui-checkbox-warning">
                      <input type="checkbox" name="include_in_main_menu"  id="include_in_main_menu"
                          >
                      <span class="input-span"></span>Yes
                  </label>
              </div>
              <!-- <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                      menu if this is not a Top Menu Category.</span></label> -->
          </div>

          <div class="row form-group">
              <label for="" class="col-sm-6">contain Sub category:</label>
              <div class="col-sm-1">
                  <label class="ui-checkbox ui-checkbox-warning">
                      <input type="checkbox" name="does_contain_sub_category"  id="does_contain_sub_category"
                          >
                      <span class="input-span"></span>Yes
                  </label>
              </div>
              <!-- <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                      menu if this doesnot have sub category.</span></label> -->
          </div>

            
          <div class="row form-group col-md-6">
            <label>Upload Category Image </label>
            <input class="form-control"  name="image" type="file" id="fileUpload">
                <div id="wrapper" class="mt-2">
                    <div id="image-holder">
                    </div>
                </div>
          </div>

            <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="publish" id="publish" type="checkbox">
                <span class="input-span"></span>Publish</label>
            </div>
            <br>
            <div class="form-group">
            <button type="submit"  class="btn btn-success ">Submit</button>
            </div>
          </form> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>