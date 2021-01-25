<?php

namespace App\Http\Controllers;

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
        return view('hosters.create');
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
        $data = $this->validate($request, [
            'title' => 'required|unique:hosters',
            'url' => 'required',
            'username' => 'nullable',
            'password' => 'nullable'
        ]);

        $hoster = new Hoster();
        $hoster->fill($data);
        $title = $hoster->title;
        
        $hoster->save();

        return redirect()->route('hosters.list')->with('message', "Хост «" . $title . "» был добавлен в таблицу.");
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
        $hoster = Hoster::findOrFail($id);
        return view('hosters.edit', compact('hoster'));
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
        $hoster = Hoster::findOrFail($id);
        $data = $this->validate($request, [
            'title' => 'required|unique:hosters,title,' . $hoster->id,
            'url' => 'required',
            'username' => 'nullable',
            'password' => 'nullable'
        ]);

        $hoster->fill($data);
        $hoster->save();
        
        return redirect()->route('hosters.list');
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
        $hoster = Hoster::findOrFail($id);
        if ($hoster) {
            $title = $hoster->title;
            $hoster->delete();
            return redirect()->route('hosters.list')->with('message', "Хост $title был удалён.");
        }

        return redirect()->route('hosters.list');
    }
}
