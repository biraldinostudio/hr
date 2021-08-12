<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

//Custom choy
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    //Custom choy
    public function __construct()
    {
        $this->middleware('guest');
    }

    //custom choy
    protected function validateEmail(Request $request)
    {
        $this->validate($request, 
            [
                'email' => 'required|email'
            ],
            $messages = [
                'email.required' => 'Alamat email wajib diisi!',
                'email.email' =>  'Alamat email tidak valid!',
            ]);
    }
}
