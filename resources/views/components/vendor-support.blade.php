<button  {{ $attributes->merge(['type' => 'button', 'id' => 'js-vendor-support-btn']) }}>Support</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">If any issue occurs while accessing dashboard, please contact our support team.</h5>
      </div>
      <div class="modal-body">
      <div class="col-lg-12 col-md-12 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-info">
                <i class="fa-solid fa-envelope-open-text"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-number">Email: Vendor@sastowholesale.com</span>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-info">
                    <i class="fa-brands fa-whatsapp text-white"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-number">Phone:  +977 9801030410</span>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@push('push_scripts')
    <script>
        $(document).ready(function () {
            $('#js-vendor-support-btn').click(function () {
                $('.modal-backdrop').remove();
                $('#exampleModal').modal('show');
            });
        });
    </script>
@endpush