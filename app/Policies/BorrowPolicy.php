<?php

namespace App\Policies;

use App\Models\Borrow;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BorrowPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return mixed
     */
    public function view(User $user, Borrow $borrow)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_libarian == 0;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return mixed
     */
    public function update(User $user, Borrow $borrow)
    {
        return $user->is_libarian == 1;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return mixed
     */
    public function delete(User $user, Borrow $borrow)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return mixed
     */
    public function restore(User $user, Borrow $borrow)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return mixed
     */
    public function forceDelete(User $user, Borrow $borrow)
    {
        //
    }
}
