<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Site;
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
            'realname' => 'nullable',
            'email' => 'required|unique:users',
            'role' => 'numeric',
            'password' => 'required|min:8',
            'yandex_login' => 'nullable',
            'telegram_login' => 'nullable',
            'pid' => 'nullable',
            'additional' => 'nullable',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user->fill($data);
        $user->save();
        return redirect()->route('users.list')->with('message', "Пользователь <b>$user->name</b> зарегистрирован.");
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
        return view('users.list');
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

        if (empty($request->password) or strlen($request->password) == 0) {
            $request->password = $user->password;
        }

        $data = $this->validate($request, [
            'name' => 'required|unique:users,name,' . $user->id,
            'password' => 'nullable',
            'realname' => 'nullable',
            'email' => 'required|unique:users,email,' . $user->id,
            'role' => 'numeric',
            'yandex_login' => 'nullable',
            'telegram_login' => 'nullable',
            'additional' => 'nullable',
            'pid' => 'nullable'
        ]);

        if ((!empty($request->password) or $request->password != '') && strlen($request->password) >= 6) {
            $data['password'] = Hash::make($request->password);
        } else {
            return redirect()->back()->withErrors(['Необходимая длина пароля не менее 6 символов. Пустое поле оставляет пароль неизменённым.']);
        }

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
        $user = User::findOrFail($id);
        if ($user) {
            $name = $user->name;
            $sites = Site::where('user_id', $id)->get();
            if ($sites) {
                foreach ($sites as $site) {
                    $site->user_id = 0;
                    $site->save();
                }
            }

            $user->delete();
            return redirect()->route('users.list')->with('message', "Пользователь <b>«" . $name . "»</b> был удалён из базы.");
        }
        return redirect()->route('users.list');
    }

    public function editProfile()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        $data = $this->validate($request, [
            'realname' => 'nullable',
            'email' => 'required|unique:users,email,' . $user->id,
            'yandex_login' => 'nullable',
            'telegram_login' => 'nullable',
            'additional' => 'nullable',
            'pid' => 'nullable'
        ]);

        if ((!empty($request->password) or $request->password != '') && strlen($request->password) >= 6) {
            $data['password'] = Hash::make($request->password);
        } elseif((!empty($request->password) or $request->password != '') && strlen($request->password) < 6) {
            return redirect()->back()->withErrors(['Необходимая длина пароля не менее 6 символов. Пустое поле оставляет пароль неизменённым.']);
        }

        $user->fill($data);
        $user->save();
        
        return redirect()->back()->with('message', "Настройки профиля успешно обновлены.");
    }
}
