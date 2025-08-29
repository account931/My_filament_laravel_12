<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method static \App\Models\User create(array $attributes = [])
 */
class OneTimeLink extends Model
{
    protected $fillable = ['token', 'used'];

    /**
     * Generate a signed, one-time, expirable URL for accessing API documentation.
     *
     * This function creates a one-time token, stores it in the database, and appends it to a
     * documentation URL along with an expiration timestamp and a signature for verification.
     * It ensures the `oneTimeToken` is in the query string (before any hash) so that middleware
     * can detect and validate it. The resulting link also includes a hash fragment pointing to
     * a specific API operation category.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing the 'expire' duration (in minutes)
     *                                             and the 'category' used to build the final hash fragment.
     * @return string The complete signed and expirable URL pointing to the API documentation section.
     */
    public function generateSignedOneTimeExpirableLink($request)
    {
        // generate and append one-time token to the route
        $oneTimeToken = Str::random(40);
        OneTimeLink::create(['token' => $oneTimeToken]);  // generates oneTimeToken to store in DB
        // $link = url('/docs/api/'.$oneTimeToken);     //generates /docs/api/$oneTimeToken
        // $link = url('/docs/api?oneTimeToken='.$oneTimeToken); // generates /docs/api?oneTimeToken=$oneTimeToken

        // fix: '?oneTimeToken='.$oneTimeToken' must be before '#' or middleware $request->query('oneTimeToken') wont catch it
        $simpleLink = url('/docs/api'.'?oneTimeToken='.$oneTimeToken);  // '#/operations/'.Str::after($request->input('category'), 'api.')); // generates /docs/api?oneTimeToken=$oneTimeToken. If route has api.'api.' removes it, if 'api/' stays
        // dd($simpleLink);

        // generate and append expiration timestamp to the route
        $expires = Carbon::now('Europe/Copenhagen')->addMinutes((int) $request->input('expire'))->timestamp;
        $temporaryUrl = $simpleLink.'&expires='.$expires;

        // generate and append signature to the signature, if u have named route, u can just URL::temporarySignedRoute('some.route.name', now()->addMinutes(30)); //(everything after #) is never sent to the server by browsers so not checked in middleware with  URL::hasValidSignature(request()
        $signature = hash_hmac('sha256', $temporaryUrl, config('app.key'));
        $signedUrl = $temporaryUrl.'&signature='.$signature;

        // append scramble link itself to the route
        $finalUrl = $signedUrl.'#/operations/'.Str::after($request->input('category'), 'api.');

        return $finalUrl;
    }
}
