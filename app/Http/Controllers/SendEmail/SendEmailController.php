<?php

//

namespace App\Http\Controllers\SendEmail;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;  // usual email
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return view('send-email.index'); // ->with(compact('users', 'currentUserNotifications'));
    }

    /**
     * Handles email form $_POST request, sends mail
     *
     * @return \Illuminate\Http\RedirectResponse Redirects back to the notification creation page
     */
    public function handleSendEmail(Request $request)
    {
        // dd($request->input()['users']);

        $request->validate([
            'message' => 'required|min:4',
            'email' => 'required|email',
            // 'users' => 'required||array',
            // 'users.*' => 'in:'.implode(',', User::pluck('id')->toArray()),  // returns '1,2', // Each tag must be in the list
        ]);

        $data = $request->input();
        // dd($data['email']);

        // Mail Facade, Variant 1, send usual email via Mail facade (just to test)
        // Mail::to($data['email'])->send(new CustomEmail('User', $data['message']));

        // Mail Facade, Variant 2, If you want to queue the email instead of sending it immediately:
        Mail::to($data['email'])->queue(new CustomEmail($data['email'], $data['message']));  // wont run unless u do => php artisan queue:work

        return redirect()->back()->with('flashSuccess', 'Your Mail Facade letter was sent successfully to user '.$data['email']);

    }
}
