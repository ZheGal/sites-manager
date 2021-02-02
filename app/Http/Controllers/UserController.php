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
        //
        $users = User::all();
        return view('users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
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
        //
        $user = User::findOrFail($id);

        $data = $this->validate($request, [
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'role' => 'numeric',
            'yandex_login' => 'nullable',
            'telegram_login' => 'nullable',
            'pid' => 'nullable'
        ]);

        $user->fill($data);
        $user->save();
        
        return redirect()->route('users.list')->with('message', "Профиль пользователя <b>«" . $user->name . "»</b> был обновлён.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
