<div class="modal fade" id="orderStatusModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Order Status</h4>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
                <label>Order Status:</label>
                <select name="order_status" id="order_status" class="form-control ">
                    <option value="New" >New</option>
                    <option value="Verified" >Verified</option>
                    <option value="Process" >Processing</option>
                    <option value="Delivered" >Delivered</option>
                    <option value="Cancel" >Cancel</option>
                </select>
            </div>
            <div class="form-group">
            <button type="button" id="submitOrderStatus" name="submit" class="btn btn-success ">Submit</button>
            </div>
          </form> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>