<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Utils\ValidatesEnvironment;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    use ValidatesEnvironment;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        // $this->validateRunningEnvironment(['local', 'development']);

        $data             = ['message' => 'This is a test!'];
        $emailPassword    = 'mail.mailers.smtp.password';
        $emailFromAddress = 'mail.from.address';
        $emailFromName    = 'mail.from.name';
        $castelloApiKey   = env('MAIL_PASSWORD_CASTELLO', config($emailPassword));
        $castelloAddress  = env('MAIL_FROM_ADDRESS_CASTELLO', config($emailFromAddress));
        $castelloName     = env('MAIL_FROM_NAME_CASTELLO', config($emailFromName));

        config([$emailPassword => $castelloApiKey]);
        config([$emailFromAddress => $castelloAddress]);
        config([$emailFromName => $castelloName]);

        Mail::to('lgalaz@gmail.com')->send(new TestEmail($data));

        return view('home');
    }
}
