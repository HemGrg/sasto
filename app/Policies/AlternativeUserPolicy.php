<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlternativeUserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return true;
        }

        if ($user->hasRole('vendor') && !is_alternative_login()) {
            return true;
        }
    }

    public function manageCategories()
    {
        return alt_usr_has_permission('categories');
    }

    public function manageProducts()
    {
        return alt_usr_has_permission('products');
    }

    public function manageOrders()
    {
        return alt_usr_has_permission('orders');
    }

    public function accessChat()
    {
        return alt_usr_has_permission('chat');
    }

    public function manageDeals()
    {
        return alt_usr_has_permission('deals');
    }

    public function viewTransactions()
    {
        return alt_usr_has_permission('transactions');
    }

    public function viewSalesReport()
    {
        return alt_usr_has_permission('sales_report');
    }
}
