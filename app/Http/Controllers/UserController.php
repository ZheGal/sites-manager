<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->is_banned()) {
            return view('banned');
        }
        
        //
        if (Auth::user()->role == 1) {
            $users = User::all();
            return view('users.list', compact('users'));
        }
        return redirect()->route('sites.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->is_banned()) {
            return view('banned');
        }
        
        //
        if (Auth::user()->role == 1) {
            return view('users.register');
        }
        return redirect()->route('sites.list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->is_banned()) {
            return view('banned');
        }
        
        //
        if (Auth::user()->role == 1) {
            $user = new User();

            $data = $this->validate($request, [
                'name' => 'required|unique:users',
                'email' => 'required|unique:users',
                'role' => 'numeric',
                'password' => 'required|min:8',
                'yandex_login' => 'nullable',
                'telegram_login' => 'nullable',
                'pid' => 'nullable'
            ]);

            $data['password'] = Hash::make($data['password']);

            $user->fill($data);
            $user->save();
            return redirect()->route('users.list')->with('message', "Пользователь $user->name зарегистрирован.");
        }
        return redirect()->route('sites.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->is_banned()) {
            return view('banned');
        }
        
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->is_banned()) {
            return view('banned');
        }
        
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($this->is_banned()) {
            return view('banned');
        }
        
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->is_banned()) {
            return view('banned');
        }
        
        //
    }
}
