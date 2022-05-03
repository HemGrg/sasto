<button  {{ $attributes->merge(['type' => 'button', 'id' => 'js-request-payment-btn']) }}>Request Payment</button>

@push('push_scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#js-request-payment-btn').click(function () {
                $(this).html('<i class="fa fa-spinner fa-spin"></i> Requesting...');
                $(this).prop('disabled', true);
                $.ajax({
                    url: '{{ route('request-payment') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Sent',
                            text: 'Your request for payment has been sent successfully.',
                        });
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong while sending your request. Please try again later.',
                        });
                    },
                    complete: function () {
                        $('#js-request-payment-btn').html('Request Payment');
                        $('#js-request-payment-btn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush