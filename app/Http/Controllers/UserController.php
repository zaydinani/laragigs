<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // show registration form
    public function create()
    {
        return view('users.register');
    }
    //create new users
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        //hash password
        $formFields['password'] = bcrypt($formFields['password']);
        //create user
        $user = User::create($formFields);
        //login
        auth()->login($user);
        return redirect('/')->with('message', 'user created and logged in successfully');
    }
    //log user out 
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'you have been Logged out');
    }
    //show login form 
    public function login()
    {
        return view('users.login');
    }
    //authenticate user 
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'you are logged in successfully');
        }
        return back()->withErrors(['email' => 'invalid credentials'])->onlyInput();
    }
}
