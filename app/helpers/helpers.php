<?php
function vendorStatus($type)
{
    switch ($type) {
        case 'approved':
            $button = 'btn-success';
            break;
        case 'suspended':
            $button = 'btn-danger';
            break;
        case 'new':
            $button = 'btn-primary';
            break;
        default:
            $button = 'btn-info';
            break;
    }
    return $button;
}

if (!function_exists('price_unit')) {
    function price_unit()
    {
        return 'Rs. ';
    }
}

if (!function_exists('formatted_price')) {
    function formatted_price($amount)
    {
        return price_unit() . number_format($amount);
    }
}


if (!function_exists('vendor_editable_package_status')) {
    function vendor_editable_package_status()
    {
        return ['pending', 'processing', 'shipped', 'completed'];
    }
}

if (!function_exists('get_order_status_number')) {
    function get_order_status_number($status)
    {
        switch ($status) {
            case "cancelled":
                $stage = 0;
                break;
            case "refunded":
                $stage = -1;
                break;
            case "pending":
                $stage = 1;
                break;
            case "processing":
                $stage = 2;
                break;
            case "shipped":
                $stage = 3;
                break;
            case "completed":
                $stage = 4;
                break;
            default:
                $stage = -100;
        }

        return $stage;
    }
}

if (!function_exists('get_package_status_number')) {
    function get_package_status_number($status)
    {
        switch ($status) {
            case "cancelled":
                $stage = 0;
                break;
            case "refunded":
                $stage = -1;
                break;
            case "pending":
                $stage = 1;
                break;
            case "processing":
                $stage = 2;
                break;
            case "shipped":
                $stage = 3;
                break;
            case "completed":
                $stage = 4;
                break;
            default:
                $stage = -100;
        }

        return $stage;
    }
}

if (!function_exists('sasto_wholesale_store_id')) {
    function sasto_wholesale_store_id()
    {
        return settings('sasto_wholesale_mall_vendor_id', null);
    }
}

if (!function_exists('is_alternative_login')) {
    function is_alternative_login()
    {
        if (session()->has('alt_usr')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('alt_usr')) {
    function alt_usr()
    {
        if (!is_alternative_login()) {
            return null;
        }

        return session()->get('alt_usr');
    }
}

if (!function_exists('alt_usr_has_permission')) {
    function alt_usr_has_permission($permision)
    {
        if (!is_alternative_login()) {
            return false;
        }
        // Some users do not have any permissions
        // In such case the permission will be null and in_array will throw error
        if (!alt_usr()->permissions) {
            return false;
        }
        return in_array($permision, alt_usr()->permissions);
    }
}

if (!function_exists('can_cancel_order')) {
    function can_cancel_order($status)
    {
        return in_array($status, ['pending']);
    }
}

if (!function_exists('admin_users')) {
    function admin_users()
    {
        return  \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
    }
}

