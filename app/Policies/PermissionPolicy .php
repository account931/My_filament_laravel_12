<?php

// To work Controller must contain, for example,  $this->authorize('view', Owner::class)  or other ways (see OwnerController/index),
// but needs nothing for Filament

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*
    List of policies for Filament, do not need to register them in Controller, like in regular Laravel
    View list    viewAny(User $user)
    View Record	view(User $user, Model $model)
    Create	    create(User $user)
    Update	    update(User $user, Model $model)
    Delete	    delete(User $user, Model $model)
    */

    /**
     * see all models
     *restricting viewAny() in a policy will also restrict access to view, edit, and delete in Filament, unless those other abilities are explicitly allowed.
     */
    public function viewAny(User $user)
    {
        return $user->can('view roles')   // return $user->id === 1
              ? Response::allow()
              : Response::deny('Stopped by OwnerPolicy, the User does not have permission "view roles"'); // way to add custom message
    }
}
