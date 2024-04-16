<?php

namespace App\Policies;

use App\Models\AppUser;
use App\Models\FinancialExpense;
use Illuminate\Auth\Access\Response;

class FinancialExpensePolicy
{
    /**
     * Determine whether the user can view models.
     */
    public function show(AppUser $appUser, FinancialExpense $financialExpense): bool
    {
        return $appUser->id == $financialExpense->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AppUser $appUser, FinancialExpense $financialExpense): bool
    {
        return $appUser->id == $financialExpense->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AppUser $appUser, FinancialExpense $financialExpense): bool
    {
        return $appUser->id == $financialExpense->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AppUser $appUser, FinancialExpense $financialExpense): bool
    {
        return $appUser->id == $financialExpense->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AppUser $appUser, FinancialExpense $financialExpense): bool
    {
        return $appUser->id == $financialExpense->user_id;
    }
}
