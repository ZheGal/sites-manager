<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Hoster;

class HosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hosters = Hoster::all();
        return view('hosters.list', compact('hosters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Auth::user()->role == 1) {
            return view('hosters.create');
        }
        return view($view, compact('sites'));
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
        if (Auth::user()->role == 1) {
            $data = $this->validate($request, [
                'title' => 'required|unique:hosters',
                'url' => 'required',
                'username' => 'nullable',
                'password' => 'nullable'
            ]);

            $hoster = new Hoster();
            $hoster->fill($data);
            $title = $hoster->title;

            $hoster->url = str_replace('https://', '', $hoster->url);
            $hoster->url = str_replace('http://', '', $hoster->url);
            
            $hoster->save();

            return redirect()->route('hosters.list')->with('message', "Хост «" . $title . "» был добавлен в таблицу.");
        }
        return view($view, compact('sites'));
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
        if (Auth::user()->role == 1) {
            $hoster = Hoster::findOrFail($id);
            return view('hosters.edit', compact('hoster'));
        }
        return view($view, compact('sites'));
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
        if (Auth::user()->role == 1) {
            $hoster = Hoster::findOrFail($id);
            $data = $this->validate($request, [
                'title' => 'required|unique:hosters,title,' . $hoster->id,
                'url' => 'required',
                'username' => 'nullable',
                'password' => 'nullable'
            ]);

            $hoster->fill($data);

            $hoster->url = str_replace('https://', '', $hoster->url);
            $hoster->url = str_replace('http://', '', $hoster->url);
            $hoster->save();
            
            return redirect()->route('hosters.list');
        }
        return view($view, compact('sites'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete host and redirect to the hosts list
        if (Auth::user()->role == 1) {
            $hoster = Hoster::findOrFail($id);
            if ($hoster) {
                $title = $hoster->title;
                $hoster->delete();
                return redirect()->route('hosters.list')->with('message', "Хост $title был удалён.");
            }

            return redirect()->route('hosters.list');
        }
        return view($view, compact('sites'));
    }
}
