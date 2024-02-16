<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Usercontroller extends Controller
{
    //create new user
    public function create(){
        return view('users.register');
    }

    public function login(){
        return view('users.login');
    }

    public function store(Request $request){
        // dd($request);
        $formFields = $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6',
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        //login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged In');
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');

    }
    public function authenticate(Request $request) {
        // dd($request);
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
