<div class="ibox">
    <div class="ibox-body">
        <div class="mb-3">
            <p>You must do settlement of your COD (Cash on delivery) / TT (Swift Transfer) to <a href="//sastowholesale.com">sastowholesale.com</a> within 3 days after we informed you.</p>
        </div>
        <table class="custom-table table table-responsive-sm">
            <thead>
                <tr>
                    <td>Transaction ID</td>
                    <td>Transaction Date</td>
                    <td>Remarks</td>
                    <td class="text-right">Sale Amount</td>
                    <td class="text-right">{{ auth()->user()->hasRole('super_admin', 'admin') ? 'To Receive' : 'Payable to Admin' }}</td>
                    <td class="text-right">Status</td>
                    @if(auth()->user()->hasAnyRole('super_admin|admin'))
                    <td class="text-right">Action</td>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($codTransactions as $transaction)
                <tr>
                    <td class="align-middle">{{ $transaction->id }}</td>
                    <td class="align-middle">{{ $transaction->created_at->format('d M, Y') }}</td>
                    <td class="align-middle">{{ $transaction->remarks }}</td>
                    <td class="align-middle text-right">{{ formatted_price($transaction->amount_before_commission) }}</td>
                    <td class="align-middle text-right">{{ formatted_price($transaction->commission) }}</td>
                    <td class="align-middle text-right">
                        <div class="js-current-status">
                            <i class="fa fa-circle mr-2 {{ $transaction->settled_at ? 'text-success' : 'text-danger' }}"></i>
                            <span>{{ $transaction->settled_at ? 'Settled' : 'Not Settled' }}</span>
                        </div>
                    </td>
                    @if(auth()->user()->hasAnyRole('super_admin|admin'))
                    <td class="align-middle text-right">
                        <button class="btn {{ $transaction->settled_at ? 'btn-danger' : 'btn-success' }} js-change-cod-transaction-status" data-transaction-id="{{ $transaction->id }}" data-new-status="{{ $transaction->settled_at ? 'unsettled' : 'settled' }}">
                            <i class="fa fa-check mr-1"></i>
                            <span>Mark {{ $transaction->settled_at ? 'Unsettled' : 'Settled' }}</span>
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('push_scripts')
    <script>
        $(document).ready(function() {
            $('.js-change-cod-transaction-status').on('click', function() {
                let eventBtn = $(this);
                var status = $(this).data('new-status');
                var transactionId = $(this).data('transaction-id');
                var url = "/transactions/change-cod-transaction-status/" + transactionId;
                var data = {
                    status: status
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function (response) {
                        let newStatus = response.new_status;
                        if(newStatus == 'settled') {
                            eventBtn.removeClass('btn-success').addClass('btn-danger');
                            eventBtn.find('i').removeClass('fa-check').addClass('fa-times');
                            eventBtn.find('span').text('Mark Unsettled');
                            eventBtn.data('new-status', 'unsettled');
                            eventBtn.closest('tr').find('.js-current-status i').removeClass('text-danger').addClass('text-success');
                            eventBtn.closest('tr').find('.js-current-status span').text('Settled');
                        } else {
                            eventBtn.removeClass('btn-danger').addClass('btn-success');
                            eventBtn.find('i').removeClass('fa-times').addClass('fa-check');
                            eventBtn.find('span').text('Mark Settled');
                            eventBtn.data('new-status', 'settled');
                            eventBtn.closest('tr').find('.js-current-status i').removeClass('text-success').addClass('text-danger');
                            eventBtn.closest('tr').find('.js-current-status span').text('Not Settled');
                        }

                        Swal.fire({
                            type: 'success',
                            title: 'Done',
                            text: "Transaction status has been changed successfully.",
                            confirmButtonText: 'Ok',
                            timer: 10000
                        });
                    },
                    error: function(error) {
                        console.log(error);
                        Swal.fire({
                            type: 'error',
                            title: 'Error',
                            text: 'Something went wrong while processing your request.',
                            confirmButtonText: 'Ok',
                            timer: 10000
                        });
                    }
                });
            });
        });
    </script>
@endpush