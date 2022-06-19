<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
            'name' => ['required', 'min:3'],
            'email' =>  ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $formData['password'] = bcrypt($formData['password']);

        $user = User::create($formData);

        auth()->login($user);

        return redirect('/')->with('message', 'User created and Login successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Authticate the user and create the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $formData = $request->validate([
            'email' =>  ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formData)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are loged in now');
        }

        return back()->withErrors(['email' => 'Invalid Credentails'])->onlyInput('email');
    }

    /**
     * Logout the User and clear the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have logout successfully');
    }
}
