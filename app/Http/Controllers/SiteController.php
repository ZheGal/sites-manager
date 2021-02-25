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
use App\Helpers\SitesHelper;
use App\Helpers\UserHelper;
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
        $query = SitesHelper::getGetQueries($request);
        $search_domain = $request->query('search_domain');

        $sites = Site::orderBy('id', 'desc');
        $filters = [];

        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            if (isset($query['user_id'])) {
                $sites = $sites->where('user_id', $query['user_id']);
                $user = User::find($query['user_id']);
                if ($user) {
                    $filters[] = ['Пользователь', $user->name , 'user_id'];
                }
            }
        } else {
            $sites = $sites->where('user_id', Auth::user()->id);
        }
        

        if (isset($query['search_domain'])) {
            $sites = $sites->where('domain', 'LIKE', '%'.$query['search_domain'].'%');
            $filters[] = ['Поиск', $query['search_domain'], 'search_domain'];
        }

        if (isset($query['status'])) {
            $sites = $sites->where('status', $query['status']);
            $filters[] = ['Статус', site_status($query['status']), 'status'];
        }

        if (isset($query['campaign_id'])) {
            $sites = $sites->where('campaign_id', $query['campaign_id']);
            $campaign = Campaign::find($query['campaign_id']);
            if ($campaign) {
                if ($campaign->language != '0') {
                    $filters[] = ['Кампания', $campaign->language . ' - ' . $campaign->title, 'campaign_id'];
                } else {
                    $filters[] = ['Кампания', $campaign->title, 'campaign_id'];
                }
            }
        }

        if (isset($query['hoster_id'])) {
            $sites = $sites->where('hoster_id', $query['hoster_id']);
            $hoster = Hoster::find($query['hoster_id']);
            if ($hoster) {
                $filters[] = ['Хостер', $hoster->title, 'hoster_id'];
            }
        }

        if (isset($query['hoster_id_domain'])) {
            $sites = $sites->where('hoster_id_domain', $query['hoster_id_domain']);
            $hoster = Hoster::find($query['hoster_id_domain']);
            if ($hoster) {
                $filters[] = ['Хостер домена', $hoster->title, 'hoster_id_domain'];
            }
        }

        $sites = $sites->paginate(50)->appends(request()->except('page'));

        return view('sites.list', compact('sites', 'search_domain', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Adding new site page
        $users = User::all();
        $hosters = Hoster::all();
        $campaigns = Campaign::all();

        return view('sites.create', compact('users', 'hosters', 'campaigns'));
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
            'domain' => 'required|unique:sites',
            'user_id' => 'numeric',
            'campaign_id' => 'required|numeric',
            'hoster_id' => 'required|numeric',
            'hoster_id_domain' => 'required|numeric',
            'ftp_host' => 'nullable',
            'ftp_user' => 'nullable',
            'ftp_pass' => 'nullable',
            'yandex' => 'nullable|numeric',
            'facebook' => 'nullable|numeric',
            'status' => 'numeric'
        ]);

        $site = new Site();
        $site->fill($data);
        $site->creator_id = Auth::user()->id;
        $site->updator_id = Auth::user()->id;

        $flysystem = new Flysystem($site);
        $flysystem->checkYandex($site);
        $flysystem->checkFacebook($site);

        $site->domain = SitesHelper::getCleanDomain($site->domain);

        if ($request->clean_host == 1) {
            $this->cleanHost($site);
        }

        $site->save();

        return redirect()->route('sites.list')->with('message', "Сайт с адресом <b>«" . $site->domain . "»</b> был добавлен в таблицу.");
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
        $site = Site::findOrFail($id);
        $users = User::all();
        $hosters = Hoster::all();
        $campaigns = Campaign::all();

        return view('sites.edit', compact('site', 'users', 'campaigns', 'hosters'));
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
        // Updating site action
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
            'facebook' => 'nullable',
            'status' => 'numeric'
        ]);

        $site->fill($data);
        $user = User::find($site->user_id);
        $add = [];
        if ($user) {
            $add['pid'] = $user->pid;
        }

        $campaign = Campaign::find($site->campaign_id);
        if ($campaign) {
            $add['group'] = $campaign->group;
        }

        $site->domain = SitesHelper::getCleanDomain($site->domain);
        $site->updator_id = Auth::user()->id;
        $site->save();

        $updateSettings = $this->updateSettingsAfterUpdateSite($site, $add);
        $updateSettingsMsg = implode(" ", $updateSettings);
        
        return redirect()->route('sites.list')->with('message', "Сайт <b>«" . $site->domain . "»</b> был обновлён. " . $updateSettingsMsg);
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
        $site = Site::findOrFail($id);
        if ($site) {
            $title = $site->domain;
            $site->delete();
            return redirect()->route('sites.list')->with('message', "Сайт <b>«" . $title . "»</b> был удалён из базы.");
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
        
        if (!empty($settings['yandex']) && $settings['yandex'] != '') {
            $site->yandex = $settings['yandex'];
        }

        if (!empty($settings['facebook']) && $settings['facebook'] != '') {
            $site->facebook = $settings['facebook'];
        }

        $json = json_encode($settings, JSON_PRETTY_PRINT);
        
        $ftp = new Flysystem($site);
        $save = $ftp->saveSettingsJson($json);
        $site->save();

        if ($save) {
            return redirect()->route('sites.list')->with('message', "Настройки сайта <b>$domain</b> успешно обновлены");
        }
    }

    public function cleanHost($site)
    {
        $url = 'http://' . $site->domain;
        
        $ftp = new Flysystem($site);

        $settings = $ftp->getSettingsJson();
        $json = json_encode($settings, JSON_PRETTY_PRINT);

        $save = $ftp->saveSettingsJson($json);
        $newProject = $ftp->uploadNewProject();
        
        @file_get_contents($url);
    }

    public function updateSettingsAfterUpdateSite($site, $add = [])
    {
        $domain = $site->domain;
        $ftpUpdate = Settings::settingsFileExists($domain);

        $get = Settings::getArray($domain);
        $array = Settings::getDefaultSettings();

        if (!empty($get) && is_array($get)) {
            $array = array_merge($array, $get);
        }

        if ($site->yandex) {
            $array['yandex'] = $site->yandex;
        }
        if ($site->facebook) {
            $array['facebook'] = $site->facebook;
        }

        $array = array_merge($array, $add);
        
        $json = json_encode($array, JSON_PRETTY_PRINT);
        
        if ($ftpUpdate) {
            $ftp = new Flysystem($site);
            $save = $ftp->saveSettingsJson($json);
            $msg[] = 'Файл settings.json на сервере обновлён.';
        } else {
            $msg[] = 'Файл settings.json на сервере не был обновлён.';
        }

        return $msg;
    }

    public function transfer(Request $request)
    {
        $site = Site::findOrFail($request->siteid);
        $site->user_id = $request->user_id;
        $site->save();
        return redirect()->route('sites.list')->with('message', "Сайт <b>$site->domain</b> успешно передан другому пользователю");
    }

    public function addGroup()
    {
        // Adding new site page
        $users = User::all();
        $hosters = Hoster::all();
        $campaigns = Campaign::all();

        return view('sites.add_group', compact('users', 'hosters', 'campaigns'));
    }

    public function storeGroup(Request $request)
    {
        $data = $this->validate($request, [
            'user_id' => 'numeric',
            'campaign_id' => 'required|numeric',
            'hoster_id' => 'required|numeric',
            'hoster_id_domain' => 'required|numeric'
        ]);

        if ($request->group_sites && !empty($request->group_sites)) {
            $group_array = SitesHelper::getGroupArray($request->group_sites);
            $group_collect = SitesHelper::getGroupCollect($group_array, $data);
            
            if (!empty($group_collect)) {
                $sitesCount = 0;

                foreach ($group_collect as $site_data) {
                    $site = new Site();
                    $site->fill($site_data);

                    $site->domain = SitesHelper::getCleanDomain($site->domain);
                    $check = Site::where('domain', $site->domain)->count();

                    if ($check == 0) {
                        $site->creator_id = Auth::user()->id;
                        $site->updator_id = Auth::user()->id;
                        $site->save();
                        $sitesCount++;
                    }

                }
                if ($sitesCount > 0) {
                    return redirect()->route('sites.list')->with('message', "В базу добавлено сайтов: <b>$sitesCount</b>.");
                }
            }

        }
        return redirect()->route('sites.list')->with('message', "Ошибка при групповом добавлении сайтов.");
    }

    public function updateConnector($id)
    {
        $site = Site::findOrFail($id);
        if ($site) {
            $this->cleanHost($site);
            return redirect()->route('sites.list')->with('message', "Набор функций для сайта <b>{$site->domain}</b> обновлён.");
        }
        return redirect()->route('sites.list')->with('message', "Произошла ошибка при попытке загрузить файлы функций на сайт <b>{$site->domain}</b>.");
    }

    public function importIndex($id)
    {
        $site = Site::findOrFail($id);
        $users = User::all();
        $hosters = Hoster::all();
        $campaigns = Campaign::all();

        return view('sites.import', compact('site', 'users', 'campaigns', 'hosters'));
    }

    public function importStore($id, Request $request)
    {
        $domain = $request->domain;
        if (!$domain) {
            // прописать вывод ошибки, отсутствие домена
            return false;
        }

        $imported = Site::where('domain', $domain)->firstOrFail();
        $script = implode(DIRECTORY_SEPARATOR, [base_path(), 'public', 'uploads', 'backup_site.php']);
        $script_name = 'script_' . substr(md5(rand()), 0, 10) . '.php';

        if ($imported) {
            $ftp = new Flysystem($imported);
            
            if (!$ftp->ftp->has('backup')) {
                $ftp->ftp->createDir('backup');
            }

            $ftp->ftp->write("backup/{$script_name}", file_get_contents($script));
            echo 'https://' . $domain . '/backup/' . $script_name;
        }
        die;
    }
}
