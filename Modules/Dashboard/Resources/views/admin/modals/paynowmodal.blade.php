<div class="modal fade" id="paynowModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pay Now</h4>
        </div>
        <div class="modal-body">
          <form id="create-category-form">
            <input type="hidden" name="user_id" value={{$id}}>
          <div class="form-group ">
              <label class="col-sm-8">Amount</label>
              <input type="text" class="form-control" name="amount" id="amount" value="{{old('amount')}}" placeholder="Enter amount">
            </div>
            
          <div class="row form-group col-md-6">
            <label>File Upload </label>
            <input class="form-control"  name="image" type="file" id="fileUpload">
                <div id="wrapper" class="mt-2">
                    <div id="image-holder">
                    </div>
                </div>
          </div>

          <div class="form-group ">
              <label class="col-sm-8">Remarks</label>
              <input type="text" class="form-control" name="remarks" id="remarks" value="{{old('remarks')}}" placeholder="Enter remarks">
            </div>

            <!-- <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="publish" id="publish" type="checkbox">
                <span class="input-span"></span>Publish</label>
            </div> -->
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