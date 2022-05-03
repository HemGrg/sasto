<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use Modules\Order\Entities\Order;

class EsewaService
{
    public $merchantId;
    public $transactionUrl;
    public $transactionVerificationUrl;

    public function __construct()
    {
        $this->merchantId = config('payments.esewa.merchant_id');
        $this->transactionUrl = config('payments.esewa.transaction_url');
        $this->transactionVerificationUrl = config('payments.esewa.transaction_verification_url');
    }

    public function generatePaymentDetails(Order $order)
    {
        return [
            'transaction_url' => $this->transactionUrl,
            'form_data' => [
                'amt' => $order->total_price,
                'psc' => 0,
                'pdc' => 0,
                'txAmt' => 0,
                'tAmt' => $order->total_price,
                'pid' => $order->id,
                'scd' => $this->merchantId,
                'su' => route('payment.esewa_success'),
                'fu' => config('constants.customer_app_url') . '/my-orders/' . $order->id . '?payment_failed=true'
            ]
        ];
    }

    /**
     * @param array $data
     * 
     * @var $data[amt] int, required
     * @var $data[rid] string, required
     * @var $data[pid] string, required
     * @var $data[scd] string, optional
     */
    public function verifyPayment($data)
    {
        if (!array_key_exists('scd', $data)) {
            $data['scd'] = $this->merchantId;
        }

        // must be sent asForm()
        $response = Http::asForm()->post($this->transactionVerificationUrl, $data);

        // mark as paid and store the refid
        if ($response->successful()) {
            // Load the xml
            $xml = simplexml_load_string($response);
            // encode the xml to json
            $json = json_encode($xml);
            // decode the json to array
            $responseArray = json_decode($json, true);
            // check the status
            $responseText = trim(str_replace('\r\n', '', $responseArray['response_code']));
            if ($responseText == 'Success') {
                return true;
            }
            return false;
        }
    }
}
