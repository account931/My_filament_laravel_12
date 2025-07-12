<?php

// API Controller

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller\Owner;
use App\Http\Controllers\Api\Collections\Owner\OwnerCollection;
use App\Http\Controllers\Api\Resources\Owner\OwnerResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\OwnerRequest;
use App\Models\Owner; // Collection list
use App\Models\User;    // Resource of 1 record
use App\Models\Venue; // base controller
use Illuminate\Http\JsonResponse; // for in: validation
use Illuminate\Http\Request; // my custom Form validation via Request Class (to create new blog & images in tables {wpressimages_blog_post} & {wpressimage_imagesstock})
use Illuminate\Validation\Rule;

class OwnerController extends Controller
{
    public function index(Request $request)   // can handle GET params
    {
        // return response()->json(Owner::all());

        $onwers = Owner::createdAtLastYear()   // createdAtLastYear, confirmed == local scope
                    // ->confirmed()  //local scope
            ->with('venues', 'venues.equipments')  // eager loading ['venues' => 'hasMany relation in models\Owner', 'venues.equipments' => 'nested relation in models\Venue, i.e $owner->venues->equipments']
                    // ->paginate(2); //version with pagination, dont use  ->get()  //navigate by => ?page=2

                    // Apply GET param from REquest
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('confirmed', $request->query('status'));
            })
                    //
            ->get();

        // return  OwnerResource::collection($onwers); //works, return collection of models through Resource, but without your customization (so u cann't add additional data like 'owners_count' => Owner::count(),'). Advantage: dont have to create your custom collection, just use build-in.
        // return response([ 'owners' => OwnerResource::collection($onwers), 'message' => 'Retrieved successfully'], 200); //v2
        return new OwnerCollection($onwers); // yo
    }

    /**
     * Show one owner. By Implicit Route Model Binding
     *
     * @return App\Http\Controllers\Api\Resources\Owner\OwnerResource;
     */
    public function show(Owner $owner): OwnerResource // JsonResource
    {
        return new OwnerResource($owner);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Owner\OwnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OwnerRequest $request)     // was Request $request    @param  \Illuminate\Http\Request  $request
    {
        $data = $request->all();

        /*
        $RegExp_Phone = '/^[+]380[\d]{1,4}[0-9]+$/';

        $existingVenues = Venue::active()->pluck('id');

        $validator = Validator::make($data, [
            'first_name' => 'required|string|min:3|max:255',
            'last_name'  => 'required|string|min:3|max:255',
            'location'      => 'required|string|min:3|max:255',
            'email'         => 'required|email|unique:owners,id,',  //email is unique on create only, not on update
            'phone'         => ['required', "regex: $RegExp_Phone" ],
            'owner_venue'   => ['required', 'array',  ],               //Rule::in($existingVenues)
            "owner_venue.*" => Rule::in($existingVenues)
        ]);


        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        */

        $owner = Owner::create($data);

        // my added line, as we need to attach venues to owner, same we do in http version
        $owner->venues()->saveMany(Venue::find($request->owner_venue)); // save hasMany

        return response(['owner' => new OwnerResource($owner), 'message' => 'Created successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Owner\OwnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    // not tested!!!!!!!!!!!!!!!
    public function update(OwnerRequest $request, Owner $owner)    // OwnerRequest $request
    {
        /* if (!$request->validated()){
            dd('zzzz');
        } */

        $data = $request->all();

        // do not get here
        /*
        if(!$request->wantsJson()){
            return response([ 'id' =>$id, 'message' => 'Retrieved successfully'], 200);
        } */

        // return response([ 'id' =>$id, 'message' => 'Retrieved successfully'], 200);

        $owner->update($request->all());

        return response(['owner' => new ownerResource($owner), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage. Protected by Passport and Spatie permission delete owners',
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Owner $owner)
    {
        $this->authorize('delete owners', Owner::class); // must have, Spatie RBAC Policy permission check (403 if fails (set in Policy). Instead of this you can also use it directly on route =>Route::middleware(['auth:api', 'can:update,post'])

        $owner->delete();

        return response(['message' => 'Deleted owner '.$owner->id]);
    }

    /**
     * Returns owners quantity. Created to test Sanctum, user must be logged (tested in console and tests)
     *
     * @return \Illuminate\Http\JsonResponse;
     */
    public function quantity(): JsonResponse
    {
        // return response([ 'owners quantity' => Owner::count(), 'message' => 'Retrieved successfully']);
        return response()->json(['status' => 'OK', 'owners quantity' => Owner::count()]);
    }

    /**
     * Returns owners quantity. Created to test Sanctum + Spatie RBAC(user must be logged and have permission 'view_owner_admin_quantity' (tested in console)
     *
     * @return \Illuminate\Http\JsonResponse;
     */
    public function quantityAdmin(): JsonResponse
    {
        $this->authorize('view_owner_admin_quantity', Owner::class); // must have, Spatie RBAC Policy permission check (403 if fails (set in Policy). Instead of this you can also use it directly on route =>Route::middleware(['auth:api', 'can:update,post'])

        // return response([ 'owners quantity' => Owner::count(), 'message' => 'Retrieved successfully']);
        return response()->json(['status' => 'OK, Admin. You have Spatie permission', 'owners quantity' => Owner::count()]);
    }
}
