<?php

namespace Modules\Front\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    protected $checkoutMode;

    public function __construct()
    {
        parent::__construct();
        $this->checkoutMode = request()->get('checkout_mode') ?? 'cart';
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = array_merge(
            [
                'address' => ['required', 'array'],
                'checkout_mode' => ['nullable'],
                'payment_type' => ['required', Rule::in(['esewa', 'connectips', 'cod'])],

                'ship_to_different_address' => ['nullable', 'boolean'],

                'address.billing.full_name' => ['required'],
                'address.billing.company_name' => ['nullable'],
                'address.billing.vat' => ['nullable'],
                'address.billing.country' => ['nullable'],
                'address.billing.city' => ['nullable'],
                'address.billing.street_address' => ['nullable'],
                'address.billing.nearest_landmark' => ['nullable'],
                'address.billing.phone' => ['nullable'],
                'address.billing.email' => ['nullable'],
            ],

            ($this->checkout_mode == 'deal') ? [
                'deal_id' => ['required', 'exists:deals,id'],
            ] : [
                'cart.*.product_id' => ['required'],
                'cart.*.product_qty' => ['required'],
                'vendorId' => ['required']
            ],

            ($this->ship_to_different_address) ? [
                'address.shipping.full_name' => ['required'],
                'address.shipping.company_name' => ['nullable'],
                'address.shipping.vat' => ['nullable'],
                'address.shipping.country' => ['nullable'],
                'address.shipping.city' => ['nullable'],
                'address.shipping.street_address' => ['nullable'],
                'address.shipping.nearest_landmark' => ['nullable'],
                'address.shipping.phone' => ['nullable'],
                'address.shipping.email' => ['nullable'],
            ] : []
        );

        return $rules;
    }

    public function billingAddress()
    {
        $address = $this->safe()['address']['billing'];
        return $address
            + [
                'type' => 'billing',
            ];
    }

    public function shippingAddress()
    {
        if ($this->ship_to_different_address) {
            $address = $this->safe()['address']['shipping'];
        } else {
            $address = $this->safe()['address']['billing'];
        }
        return $address
            + [
                'type' => 'shipping',
            ];
    }

    public function isDealCheckout()
    {
        return $this->checkout_mode === 'deal';
    }
}
