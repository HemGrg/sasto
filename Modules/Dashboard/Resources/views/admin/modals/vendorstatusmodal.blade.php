<div class="modal fade" id="vendorstatusModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Vendor Status</h4>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
                <label>Vendor Status:</label>
                <select name="vendor_type" id="vendor_status" class="form-control ">
                    <option value="new" >New</option>
                    <option value="approved" >Approve</option>
                    <option value="suspended" >Suspend</option>
                </select>
            </div>
            <div class="form-group">
            <button type="button" id="submitVendorStatus" name="submit" class="btn btn-success ">Submit</button>
            </div>
          </form> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>