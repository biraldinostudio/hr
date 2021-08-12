<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use DeepCopy\Filter\Filter;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function nrp(){
        return 'nrp';
    }

    public function login(Request $request)
    {
        
        $rules = [
            'nrp' => 'required',
            'password' => 'required',
        ];
        $customMessages = [
            'required' => ':attribute wajib diisi.'
        ];
    
        $customAttributes = [
            'nrp'=>'NRP',
            'password'=>'Kata sandi',
        ];

        $this->validate($request, $rules, $customMessages,$customAttributes);        
        
        $input=$request->all();
 
        $fieldType=filter_var($request->nrp,FILTER_VALIDATE_EMAIL)? 'email' :'nrp';
        if(auth()->attempt(array($fieldType=>$input['nrp'],'password'=>$input['password']))){
            return redirect()->route('home');

        }else{
            return back()->with('error','NRP atau kata sandi salah!');
            
        }
    }
}
