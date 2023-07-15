<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class RolePolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny():bool
    {
        //
       return Auth::user()->role->name=="مدير النظام";
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin): bool
    {
        //

        return Auth::user()->role->name=="مدير النظام";

    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(): bool
    {
        //
        return Auth::user()->role->name=="مدير النظام";

    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(): bool
    {
        //
        return Auth::user()->role->name=="مدير النظام";

    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(): bool
    {
        return Auth::user()->role->name=="مدير النظام";

    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(): bool
    {
        //
        return Auth::user()->role->name=="مدير النظام";

    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        //
        return Auth::user()->role->name=="مدير النظام";

    }
}
