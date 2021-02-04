<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        //
        $campaigns = Campaign::orderBy('group')->get();
        return view('campaigns.list', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('campaigns.create');
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
            'title' => 'required|unique:campaigns',
            'language' => 'required',
            'group' => 'nullable|numeric'
        ]);

        $campaign = new Campaign();
        $campaign->fill($data);
        $title = $campaign->language . ' - ' .$campaign->title;
        
        $campaign->save();

        return redirect()->route('campaigns.list')->with('message', "Кампания <b>«" . $title . "»</b> была добавлена в таблицу.");
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
        $campaign = Campaign::findOrFail($id);
        return view('campaigns.edit', compact('campaign'));
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
        $campaign = Campaign::findOrFail($id);
        $data = $this->validate($request, [
            'title' => 'required|unique:campaigns,title,' . $campaign->id,
            'language' => 'required',
            'group' => 'nullable|numeric'
        ]);

        $campaign->fill($data);
        $title = $campaign->language . ' - ' .$campaign->title;
        
        $campaign->save();

        return redirect()->route('campaigns.list')->with('message', "Кампания <b>«" . $title . "»</b> была обновлёна.");
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
        $campaign = Campaign::findOrFail($id);
        if ($campaign) {
            $title = $campaign->title;
            $campaign->delete();
            return redirect()->route('campaigns.list')->with('message', "Кампания <b>«" . $title . "»</b> была удалёна.");
        }

        return redirect()->route('campaigns.list');
    }
}
