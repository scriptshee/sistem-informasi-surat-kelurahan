<?php

namespace App\Policies;

use App\Models\Surat\Masuk;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuratMasukPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(['admin', 'sekretaris', 'lurah', 'staff', 'pelayanan']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Surat\Masuk  $masuk
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Masuk $masuk)
    {
        return $user->hasRole(['admin', 'sekretaris', 'lurah', 'pelayanan']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole(['admin', 'sekretaris', 'pelayanan']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Surat\Masuk  $masuk
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Masuk $masuk)
    {
        return $user->hasRole(['admin', 'sekretaris', 'lurah']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Surat\Masuk  $masuk
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Masuk $masuk)
    {
        return $user->hasRole(['admin', 'sekretaris', 'lurah']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Surat\Masuk  $masuk
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Masuk $masuk)
    {
        return $user->hasRole(['admin', 'sekretaris', 'lurah']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Surat\Masuk  $masuk
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Masuk $masuk)
    {
        return $user->hasRole(['admin', 'sekretaris', 'lurah']);
    }
}
