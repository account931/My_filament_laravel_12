<?php
//This policy is for testing purpose mainly. In this case it authorize if user id is 1
//To work Controller must contain, for example,  $this->authorize('view', Owner::class)  or other ways (see OwnerController/index),
 //but needs nothing for Filament
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Owner;
use Illuminate\Auth\Access\Response;

class OwnerPolicy
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
	* see all models, View List
    *restricting viewAny() in a policy will also restrict access to view, edit, and delete in Filament, unless those other abilities are explicitly allowed.
	*/
	public function viewAny(User $user)

    {
        return $user->can('view owners')   // return $user->hasRole('admin');  //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Stopped by OwnerPolicy, the User does not have permission "view owners"'); //way to add custom message
			   
		//return $user->can('access campaigns');
		//return $user->id === $owner->user_id;
    }



	/*
	public function index(User $user)
    {
        return $user->can('view owners')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Stopped by OwnerPolicy, the User does not have permission "view owners"'); //way to add custom message
			   
		//return $user->can('access campaigns');
		//return $user->id === $owner->user_id;
    }
		*/

	/**
	* see all models (must be use viewAny instead of index ??)
	*/
	
	/*
	public function viewAny(User $user)
    {
		return $user->id === 1;
	}
	*/
		
	/**
	* see individual models
	*/
	public function view(User $user)
    {
        return $user->can('view owner')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Cannot see 1 model, stopped by OwnerPolicy, the User does not have permission "view owner"'); //way to add custom message
    }

	
    public function update(User $user)
    {
		return $user->can('edit owners')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Cant update, Stopped by OwnerPolicy, the User does not have permission "edit owners"'); //way to add custom message
    }
	

	
    public function delete(User $user)
    {
        //return $user->id === $owner->user_id;
		return $user->can('delete owners')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Cant delete, Stopped by OwnerPolicy, the User does not have permission "delete owners"'); //way to add custom message
    }
	
	
	//permission to test API Route::get('/owners/quantity/admin', user must be logged (Passport) + has a Spatie RBAC permission
	public function view_owner_admin_quantity(User $user)
    {
		//return $user->hasPermissionTo('view owner admin quantity')
		return $user->can('view owner admin quantity', 'api')  //fix for Laravel 12, was crashing      //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Sorry. Stopped by OwnerPolicy, the User does not have permission "view owner admin quantity"'); //way to add custom message
    }
	
}
