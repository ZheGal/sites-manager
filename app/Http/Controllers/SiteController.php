<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Hoster;
use App\Models\User;
use App\Models\Campaign;
use App\Helpers\Settings;
use App\Helpers\Flysystem;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Sites list
        $campaign_id = $request->query('campaign_id');
        $hoster_id = $request->query('hoster_id');
        $hoster_id_domain = $request->query('hoster_id_domain');
        $user_id = $request->query('user_id');
        $search_domain = $request->query('search_domain');

        $view = 'sites.list';

        $sites = Site::orderBy('id', 'desc');

        if (Auth::user()->role == 1) {
            if (!empty($user_id)) {
                $sites = $sites->where('user_id', $user_id);
            }
        } else {
            $sites = $sites->where('user_id', Auth::user()->id);
        }
        

        if (!empty($search_domain)) {
            $sites = $sites->where('domain', 'LIKE', '%'.$search_domain.'%');
        }

        if (!empty($campaign_id)) {
            $sites = $sites->where('campaign_id', $campaign_id);
        }

        if (!empty($hoster_id)) {
            $sites = $sites->where('hoster_id', $hoster_id);
        }

        if (!empty($hoster_id_domain)) {
            $sites = $sites->where('hoster_id_domain', $hoster_id_domain);
        }

        $sites = $sites->paginate(100);

        return view($view, compact('sites', 'search_domain'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Adding new site page
        if (Auth::user()->role == 1) {
            $users = User::all();
            $hosters = Hoster::all();
            $campaigns = Campaign::all();

            return view('sites.create', compact('users', 'hosters', 'campaigns'));
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
        //
        if (Auth::user()->role == 1) {
            $data = $this->validate($request, [
                'domain' => 'required|unique:sites',
                'user_id' => 'numeric',
                'campaign_id' => 'required|numeric',
                'hoster_id' => 'required|numeric',
                'hoster_id_domain' => 'required|numeric',
                'ftp_host' => 'nullable',
                'ftp_user' => 'nullable',
                'ftp_pass' => 'nullable',
                'yandex' => 'nullable|numeric',
                'facebook' => 'nullable|numeric'
            ]);

            $site = new Site();
            $site->fill($data);
            $title = $site->domain;

            $site->domain = str_replace('http://', '', $site->domain);
            $site->domain = str_replace('https://', '', $site->domain);

            if ($request->clean_host == 1) {
                $this->cleanHost($site);
            }

            $site->save();

            return redirect()->route('sites.list')->with('message', "Сайт с адресом «" . $title . "» был добавлен в таблицу.");
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
            $site = Site::findOrFail($id);
            $users = User::all();
            $hosters = Hoster::all();
            $campaigns = Campaign::all();

            return view('sites.edit', compact('site', 'users', 'campaigns', 'hosters'));
        }
        return redirect()->route('sites.list');
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
            $site = Site::findOrFail($id);        
            $data = $this->validate($request, [
                'domain' => 'required|unique:sites,domain,' . $site->id,
                'user_id' => 'numeric',
                'campaign_id' => 'required|numeric',
                'hoster_id' => 'required|numeric',
                'hoster_id_domain' => 'required|numeric',
                'ftp_host' => 'nullable',
                'ftp_user' => 'nullable',
                'ftp_pass' => 'nullable',
                'yandex' => 'nullable',
                'facebook' => 'nullable'
            ]);

            $site->fill($data);

            $site->domain = str_replace('https://', '', $site->domain);
            $site->domain = str_replace('http://', '', $site->domain);
            $site->save();

            $updateSettings = $this->updateSettingsAfterUpdateSite($site);
            
            return redirect()->route('sites.list')->with('message', "Сайт «" . $site->domain . "» был обновлён.");
        }
        return redirect()->route('sites.list');
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
        if (Auth::user()->role == 1) {
            $site = Site::findOrFail($id);
            if ($site) {
                $title = $site->domain;
                $site->delete();
                return redirect()->route('sites.list')->with('message', "Сайт «" . $title . "» был удалён из базы.");
            }
        }
        return redirect()->route('sites.list');
    }

    public function editSettings($id)
    {
        $site = Site::findOrFail($id);
        $domain = $site->domain;
        $settings = collect(Settings::getArray($domain));
        if (!empty($settings)) {
            return view('sites.edit_settings', compact('settings', 'site'));
        } else {
            return redirect()->route('sites.list');
        }
    }

    public function updateSettings(Request $request, $id)
    {
        $site = Site::findOrFail($id);
        $domain = $site->domain;
        
        $settings = Settings::compareSettingAfterUpdateSubmit();
        $json = json_encode($settings, JSON_PRETTY_PRINT);
        
        $ftp = new Flysystem($site);
        $save = $ftp->saveSettingsJson($json);

        if ($save) {
            return redirect()->route('sites.list')->with('message', "Настройки сайта $domain успешно обновлены");
        }
    }

    public function cleanHost($site)
    {   
        $url = 'https://' . $site->domain;

        $settings = Settings::compareSettingsAfterCreate($site);
        $json = json_encode($settings, JSON_PRETTY_PRINT);
        
        $ftp = new Flysystem($site);
        $save = $ftp->saveSettingsJson($json);
        $newProject = $ftp->uploadNewProject();
        
        file_get_contents($url);
    }

    public function updateSettingsAfterUpdateSite($site)
    {
        $domain = $site->domain;
        $get = Settings::getArray($domain);
        $array = Settings::getDefaultSettings();

        if (!empty($get) && is_array($get)) {
            $array = array_merge($array, $get);
        }

        if (!empty($site->yandex)) {
            $array['yandex'] = $site->yandex;
        }
        if (!empty($site->facebook)) {
            $array['facebook'] = $site->facebook;
        }
        
        $json = json_encode($array, JSON_PRETTY_PRINT);
        
        $ftp = new Flysystem($site);
        $save = $ftp->saveSettingsJson($json);
    }

    public function transfer(Request $request)
    {
        $site = Site::findOrFail($request->siteid);
        $site->user_id = $request->user_id;
        $site->save();
        return redirect()->route('sites.list')->with('message', "Сайт $site->domain успешно передан другому пользователю");
    }
}
