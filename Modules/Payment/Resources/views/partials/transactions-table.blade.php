<div class="ibox">
    <div class="ibox-body">
        @if(auth()->user()->hasRole('vendor'))
        <div class="mb-3">
            <p>If your payment need to be settled, click the "Request Payment" button below. If any confusion related to finance kindly mail at <a href="mailto:finance@sastowholesale.com">finance@sastowholesale.com</a>.</p>
            <x-payment-request-button class="btn btn-primary border-0"></x-payment-request-button>
        </div>
        @endif

        <table class="custom-table table table-responsive-sm">
            <thead>
                <tr>
                    <td>Transaction ID</td>
                    <td>Transaction Date</td>
                    <td>Remarks</td>
                    {{-- <td class=" text-right">Withdraw</td> --}}
                    <td class="text-right">Amount</td>
                    <td class="text-right">Balance</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                    <td>
                        <div>
                            {{ $transaction->remarks }}
                        </div>
                        @if ($transaction->file)
                        <div>
                            <a href="{{ $transaction->fileUrl() }}" target="_blank">View attachment</a>
                        </div>
                        @endif
                    </td>
                    {{-- <td class="text-right text-danger">{{ $transaction->type == 0 ? formatted_price($transaction->amount) : '-' }}</td> --}}
                    <td class="text-right {{ $transaction->type == 1 ? 'text-success' : 'text-danger' }}">{{ formatted_price($transaction->amount) }}</td>
                    <td class="text-right">{{ formatted_price($transaction->running_balance) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
