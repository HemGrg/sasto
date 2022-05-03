<?php

namespace Modules\Payment\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Rendersable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Entities\Transaction;
use Modules\Payment\Service\TransactionService;
use Modules\User\Entities\Vendor;

class TransactionController extends Controller
{
    use AuthorizesRequests;
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(User $user)
    {
        $this->authorize('viewTransactions');
        $vendor = $user->vendor;

        if (!auth()->user()->hasAnyRole('super_admin|admin')) {
            abort_unless(auth()->id() == $user->id, 403);
        }

        $transactions = Transaction::where('vendor_id', $vendor->id)
            ->onlyOnlinePayments()
            ->orderBy('id', 'DESC')->get();

        $codTransactions = Transaction::where('vendor_id', $vendor->id)
            ->onlyCOD()
            ->latest()->get();

        $vendorUser = $user;
        $currentBalance = $this->transactionService->getCurrentBalance($vendor->id);

        return view('payment::transactions-listing', compact([
            'transactions',
            'vendor',
            'codTransactions',
            'vendorUser',
            'currentBalance',
        ]));
    }

    public function recordPayment(Request $request, $vendorUserId)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        $vendor = Vendor::where('user_id', $vendorUserId)->first();

        $request->validate([
            'amount' => 'required|numeric',
            'created_at' => 'nullable|date',
            'remarks' => 'required|string',
            'file' => 'nullable',
        ]);

        $currentBalance = $this->transactionService->getCurrentBalance($vendor->id);
        $transaction = new Transaction();
        $transaction->vendor_id = $vendor->id;
        $transaction->type = 0;
        $transaction->amount = $request->amount;
        $transaction->running_balance = $currentBalance - $request->amount;
        $transaction->remarks = $request->remarks;
        $transaction->created_at = $request->created_at ?? now();
        if ($request->hasFile('file')) {
            $transaction->file = $request->file('file')->store('transactions');
        }
        $transaction->save();

        $vendor->user->notify(new \Modules\Payment\Notifications\PaymentReceivedNotification($transaction, $vendor));

        return redirect()->route('transactions.index', $vendorUserId)->with('success', 'Payment recorded successfully.');
    }

    public function changeCodTransactionStatus(Request $request, Transaction $transaction)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        $request->validate([
            'status' => 'required|in:settled,unsettled',
        ]);

        $transaction->update([
            'settled_at' => $request->status == 'settled' ? now() : null
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Transaction status updated successfully.', 'new_status' => $transaction->settled_at ? 'settled' : 'unsettled']);
        }

        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }
}
