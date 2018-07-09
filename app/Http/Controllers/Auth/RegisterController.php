<?php

namespace App\Http\Controllers\Auth;

use App\Mail\verifyEmail;
use App\User;
use App\Coordinator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function coorValidator(array $data)
    {
        return Validator::make($data, [
            'username'          => 'required|string|max:255|unique:users',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:6|confirmed',
            'first-name'        => 'required',
            'middle-name'       => 'required',
            'last-name'         => 'required',
            'department'        => 'required',
            'contact-1'         => 'required'
        ]);
    }

    protected function sponsorValidator(array $data)
    {
        return Validator::make($data, [

        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
            'vToken'    => str_random(40),
            'verified'  => false,
            'isOnline'  => false,
            'isFilled'  => false
        ]);

        $user->attachRole('student');

        $thisUser = User::findOrFail($user->id);
        $this->sendMail($thisUser);
    }

    protected function coorCreate(array $data)
    {
        $user = User::create([
            'name'      => $data['username'],
            'email'     => $data['email'],
            'password'  => bcrypt( $data['password']),
            'vToken'    => '',
            'verified'  => false,
            'isOnline'  => false,
            'isFilled'  => false
        ]);

        $user->attachRole('coordinator');

        Coordinator::create([
            'user_id'       => $user->id,
            'firstName'     => $data['first-name'],
            'middleName'    => $data['middle-name'],
            'lastName'      => $data['last-name'],
            'department'    => $data['department'],
            'position'      => $data['position'],
            'contact'       => $data['contact-1']
        ]);

    }

    protected function sponsorCreate(array $data)
    {

    }

    public function sendMail($thisUser)
    {
        Mail::to($thisUser->email)->send(new verifyEmail($thisUser));
    }

    public function verified($email, $token)
    {
        $user = User::where(['email' => $email, 'vToken' => $token])->update(['verified' => 1, 'vToken' => '']);

        return redirect()->route('login')->with('Info', '<b>Activated!</b>'.$email.' verified!');
    }
}
