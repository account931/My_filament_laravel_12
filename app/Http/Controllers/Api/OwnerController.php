<?php
//API Controller
namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller\Owner;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Collections\Owner\OwnerCollection;
use App\Http\Controllers\Controller;


class OwnerController extends Controller
{
    public function test_endpoint()
    {
        //return response()->json(Owner::all());

        $onwers = Owner::createdAtLastYear()   //createdAtLastYear, confirmed == local scope
		            //->confirmed()  //local scope
		            ->with('venues', 'venues.equipments')  //eager loading ['venues' => 'hasMany relation in models\Owner', 'venues.equipments' => 'nested relation in models\Venue, i.e $owner->venues->equipments']
		            //->paginate(2); //version with pagination, dont use  ->get()  //navigate by => ?page=2
					->get(); 
					
		//return  OwnerResource::collection($onwers); //works, return collection of models through Resource, but without your customization (so u cann't add additional data like 'owners_count' => Owner::count(),'). Advantage: dont have to create your custom collection, just use build-in.
		//return response([ 'owners' => OwnerResource::collection($onwers), 'message' => 'Retrieved successfully'], 200); //v2
		return new OwnerCollection($onwers); //yo
    }
}
