<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Helpers\Neogara;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $settings = $this->get_all_settings();
        return view('settings.index', ['settings' => $settings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        foreach ($request->all() as $param => $value) {
            if ($param[0] != '_' & $param != '') {
                $setting = Setting::where('param', $param)->first();
                if (!$setting) {
                    $new = new Setting();
                    $new->param = $param;
                    $new->value = $value;
                    $new->save();
                } else {
                    $setting->value = $value;
                    $setting->save();
                }
            }
        }

        $neo_token = $this->check_neogara_token($request->all());
        
        if ($neo_token) {
            $setting = Setting::where('param', 'neogara_token')->first();
            if (!$setting) {
                $new = new Setting();
                $new->param = 'neogara_token';
                $new->value = $neo_token;
                $new->save();
            } else {
                $setting->value = $neo_token;
                $setting->save();
            }
        }

        return redirect()->route('settings.index')->with('message', "Настройки сохранены");
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
        //
    }

    public function get_all_settings()
    {
        $array = [];
        $settings = Setting::all();
        if ($settings) {
            foreach ($settings as $setting) {
                $array[$setting->param] = $setting->value;
            }
        }
        return collect($array);
    }

    public function check_neogara_token($request)
    {
        $username = ($request['neogara_login']) ? $request['neogara_login'] : false;
        $password = isset($request['neogara_password']) ? $request['neogara_password'] : false;
        if ($username == false or $password == false) {
            return false;
        }

        $neogara = new Neogara();
        $token = $neogara->get_auth([
            'username' => $username,
            'password' => $password
        ]);

        return ($token) ? $token : false;

    }
}
