<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Hoster;
use App\Models\User;
use App\Models\TestResult;
use App\Helpers\Settings;
use App\Helpers\Flysystem;
use App\Helpers\SitesHelper;
use App\Helpers\UserHelper;
use App\Helpers\Neogara;
use App\Helpers\Offers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
        $neo = new Neogara();
        $offers = $neo->get_offers();
        $count = Offers::count_sites($offers);

        if (Auth::user()->role != 1 && Auth::user()->role != 2) {
            $offers = Offers::only_users_offers($offers, $count);
        }
        $offersMenu = Offers::linksForMenu($offers, $count);

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

        if (isset($query['type'])) {
            $sites = $sites->where('type', $query['type']);
            $filters[] = ['Тип сайта', $query['type'], 'type'];
        }

        if (isset($query['status'])) {
            $sites = $sites->where('status', $query['status']);
            $filters[] = ['Статус', site_status($query['status']), 'status'];
        }

        if (isset($query['campaign_id'])) {
            $sites = $sites->where('campaign_id', $query['campaign_id']);
            $campaign = $neo->get_offer($query['campaign_id']);
            if ($campaign) {
                $camp_lang = $campaign['languages'][0]->alpha3;
                $camp_name = $campaign['name'];
                if (!empty($campaign['languages'])) {
                    $filters[] = ['Кампания', $camp_lang . ' - ' . $camp_name, 'campaign_id'];
                } else {
                    $filters[] = ['Кампания', $camp_name, 'campaign_id'];
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

        return view('sites.list', compact('sites', 'search_domain', 'filters', 'offers', 'offersMenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Adding new site page
        $neo = new Neogara();
        $users = User::all();
        $hosters = Hoster::all();
        $offers = $neo->get_offers();

        return view('sites.create', compact('users', 'hosters', 'offers'));
    }

    public function createCurrent()
    {
        $neo = new Neogara();
        $users = User::all();
        $hosters = Hoster::all();
        $offers = $neo->get_offers();

        return view('sites.create_current', compact('users', 'hosters', 'offers'));
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
        $request->domain = SitesHelper::getCleanDomain($request->domain);

        $data = $this->validate($request, [
            'domain' => 'required|unique:sites',
            'user_id' => 'numeric',
            'pid' => 'nullable',
            'campaign_id' => 'required|numeric',
            'hoster_id' => 'required|numeric',
            'hoster_id_domain' => 'required|numeric',
            'ftp_host' => 'nullable',
            'ftp_user' => 'nullable',
            'ftp_pass' => 'nullable',
            'yandex' => 'nullable|numeric',
            'facebook' => 'nullable|numeric',
            'status' => 'numeric',
            'type' => 'required',
            'relink' => 'nullable'
        ]);

        $data['pid'] = Settings::checkPid($data);

        $site = new Site();
        $site->fill($data);
        $site->creator_id = Auth::user()->id;
        $site->updator_id = Auth::user()->id;

        $settings = Settings::newSiteSettings($request);
        
        if ($site->campaign_id == '0' or empty($site->campaign_id)) {
            if (!empty($settings['group'])) {
                $site->campaign_id = $settings['group'];
            }
        }
        if ($site->yandex == '0' or empty($site->yandex)) {
            if (!empty($settings['yandex'])) {
                $site->yandex = $settings['yandex'];
            }
        }
        if ($site->facebook == '0' or empty($site->facebook)) {
            if (!empty($settings['facebook'])) {
                $site->facebook = $settings['facebook'];
            }
        }
        if ($site->cloakit == '0' or empty($site->cloakit)) {
            if (!empty($settings['cloakit'])) {
                $site->cloakit = $settings['cloakit'];
            }
        }

        if ($request->clean_host == 1) {
            $this->cleanHost($site);
        }

        $site->save();

        return redirect()->route('sites.list')->with('message', "Сайт с адресом <b>«" . $site->domain . "»</b> был добавлен в таблицу.");
    }

    public function storeCurrent(Request $request)
    {
        // проверка наличия домена в базе
        $site = Site::where('domain', $request->domain)->first();
        if ($site) {
            return redirect()->route('sites.list')->with('message', "Сайт с адресом <b>«" . $site->domain . "»</b> уже существует в базе.");
        }
        
        $settings = Settings::newSiteSettings($request);
        $site = SitesHelper::newIssetSite($request, $settings);

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
        
        if (Auth::user()->role != 1 && Auth::user()->role != 2) {
            if (Auth::user()->id != $site->user_id) {
                return redirect()->route('sites.list')->with('message', "Попытка отредактировать сайт, не принадлежащий данному пользователю");
            }
        }

        $users = User::all();
        $hosters = Hoster::all();
        $neo = new Neogara();
        $offers = $neo->get_offers();
        $settings = Settings::getArray($site->domain);
        $settings = Settings::getCompareWithBase($settings, $site);

        return view('sites.edit', compact('settings', 'users', 'hosters', 'offers'));
    }

    public function editSettings($id)
    {
        $site = Site::findOrFail($id);
        
        if (Auth::user()->role != 1 && Auth::user()->role != 2) {
            if (Auth::user()->id != $site->user_id) {
                return redirect()->route('sites.list')->with('message', "Попытка отредактировать сайт, не принадлежащий данному пользователю");
            }
        }

        return view('sites.edit_data', compact('site'));
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
        $add = [];
        $site = Site::findOrFail($id);
        $data = $this->validate($request, [
            'domain' => 'required|unique:sites,domain,' . $site->id,
            'user_id' => 'numeric',
            'campaign_id' => 'required|numeric',
            'hoster_id' => 'numeric',
            'hoster_id_domain' => 'numeric',
            'pid' => 'nullable',
            'ftp_host' => 'nullable',
            'ftp_user' => 'nullable',
            'ftp_pass' => 'nullable',
            'yandex' => 'nullable',
            'facebook' => 'nullable',
            'cloakit' => 'nullable|numeric',
            'status' => 'numeric',
            'type' => 'required',
            'relink' => 'nullable'
        ]);

        $site->fill($data);
        
        $user = User::find($site->user_id);
        if ($user) {
            $add['pid'] = $user->pid;
        }
        $add['group'] = $data['campaign_id'];
        $add['domain'] = $data['domain'];
        $site->domain = SitesHelper::getCleanDomain($site->domain);
        $site->updator_id = Auth::user()->id;
        
        $settings = Settings::updateSite($site);
        $site->save();
        $this->cleanHost($site);
        
        return redirect()->route('sites.list')->with('message', "Сайт <a href='//{$site->domain}' target='_blank'><b>«" . $site->domain . "»</b></a> был обновлён. " . $settings);
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
        $neo = new Neogara();
        $offers = $neo->get_offers();

        return view('sites.add_group', compact('users', 'hosters', 'offers'));
    }

    public function storeGroup(Request $request)
    {
        $data = $this->validate($request, [
            'user_id' => 'numeric',
            'campaign_id' => 'required|numeric',
            'hoster_id' => 'required|numeric',
            'hoster_id_domain' => 'required|numeric',
            'type' => 'required'
        ]);

        if ($request->group_sites && !empty($request->group_sites)) {
            $group_array = SitesHelper::getGroupArray($request->group_sites);
            $group_collect = SitesHelper::getGroupCollect($group_array, $data);
            
            if (!empty($group_collect)) {
                $sitesCount = 0;

                foreach ($group_collect as $site_data) {
                    $site = new Site();
                    $site->fill($site_data);

                    if (!empty($request->relink) or $request->relink != '') {
                        $site->relink = $request->relink;
                    }

                    $site->domain = SitesHelper::getCleanDomain($site->domain);
                    $check = Site::where('domain', $site->domain)->count();

                    if ($data['type'] == 'prelandWithLand') {
                        $site->relink = '/registration.php';
                    }

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

        return view('sites.import', compact('site', 'users', 'hosters'));
    }

    public function importStore($id, Request $request)
    {
        $domain = $request->domain;
        $current = Site::findOrFail($id);
        
        if (!$domain) {
            // прописать вывод ошибки, отсутствие домена
            return false;
        }

        $imported = Site::where('domain', $domain)->firstOrFail();
        $script = implode(DIRECTORY_SEPARATOR, [base_path(), 'public', 'uploads', 'backup_site.php']);
        $scriptUpload = implode(DIRECTORY_SEPARATOR, [base_path(), 'public', 'uploads', 'upload_backup.php']);
        $script_name = 'script_' . substr(md5(rand()), 0, 10) . '.php';
        $script_name_upload = 'script_' . substr(md5(rand()), 0, 10) . '.php';

        // если в нашей базе есть доступ к импортируемому сайту
        if ($imported) {
            $ftp = new Flysystem($imported);
            
            if (!$ftp->ftp->has('backup')) {
                $ftp->ftp->createDir('backup');
            }

            $ftp->ftp->write("public/{$script_name}", file_get_contents($script));
            $scriptUrl = 'https://' . $domain . '/' . $script_name;
            $zipLink = @file_get_contents($scriptUrl);

            if (!$zipLink) {
                return redirect()->route('sites.list')->with('message', 
                "Произошла ошибка при попытке импортировать сайт <a href='//{$domain}' target='_blank'>{$domain}</a> на домен <a href='//{$current->domain}' target='_blank'><b>{$current->domain}</b></a>.");
            }

            $scriptUploadRaw = file_get_contents($scriptUpload);
            $scriptUploadRaw = str_replace('%%ARCHIVE_URL%%', $zipLink, $scriptUploadRaw);
            // скрипт выше нужно залить на фтп и запустить
            // первоначально удалить существующую папку public, либо задать ей название public_old (если она не пустая)

            $new = new Flysystem($current);

            if ($new->ftp->has('public')) {
                $contents = $new->ftp->listContents('public');
                if (!empty($contents)) {
                    if ($new->ftp->has('public_old')) {
                        $new->ftp->deleteDir('public_old/');
                    }
                    $new->ftp->rename('public', 'public_old');
                }
                $new->ftp->write("public/{$script_name_upload}", $scriptUploadRaw);
                $final = 'http://' . $current->domain . '/' .$script_name_upload;
                file_get_contents($final);
            }

            $newContentList = $new->ftp->listContents('public');
            foreach ($newContentList as $checkScriptFiles) {
                $re = '/(public\/script_.+.php)/mU';
                preg_match_all($re, $checkScriptFiles['path'], $matches, PREG_SET_ORDER, 0);
                if (!empty($matches)) {
                    $new->ftp->delete($matches[0][0]);
                    if ($ftp->ftp->has($matches[0][0])) {
                        $ftp->ftp->delete($matches[0][0]);
                    }
                }
            }

            if ($ftp->ftp->has("public/{$script_name}")) {
                $ftp->ftp->delete("public/{$script_name}");
            }

            $zipFileDelete = explode('/', $zipLink);
            $zipFileDelete = end($zipFileDelete);

            if ($ftp->ftp->has("backup/{$zipFileDelete}")) {
                $ftp->ftp->delete("backup/{$zipFileDelete}");
            }

            if (empty($ftp->ftp->listContents('backup/'))) {
                $ftp->ftp->deleteDir('backup/');
            }
            return redirect()->route('sites.list')->with('message', 
            "Сайт <a href='//{$domain}' target='_blank'>{$domain}</a> импортирован на домен <a href='//{$current->domain}' target='_blank'><b>{$current->domain}</b></a>.");
        } 
        return redirect()->route('sites.list')->with('message', 
        "Произошла ошибка при попытке импортировать сайт <a href='//{$domain}' target='_blank'>{$domain}</a> на домен <a href='//{$current->domain}' target='_blank'><b>{$current->domain}</b></a>.");
    }

    public function updateSettings(Request $request, $id)
    {
        $site = Site::findOrFail($id);
        $data = [
            'domain' => str_replace(" ", "", trim($request->domain, " \t\n")),
            'ftp_host' => str_replace(" ", "", trim($request->ftp_host, " \t\n")),
            'ftp_user' => str_replace(" ", "", trim($request->ftp_user, " \t\n")),
            'ftp_pass' => str_replace(" ", "", trim($request->ftp_pass, " \t\n")),
            'status' => $request->status
        ];
        $site->fill($data);
        $site->save();
        return redirect()->route('sites.list')->with('message', "Настройки сайта <strong>$site->domain</strong> были обновлены.");
    }

    // action на выполнение тестов по домену
    public function testrun($id)
    {
        set_time_limit(999999);
        $apiUrl = \App\Models\Setting::where('param', 'testing_api')->first()->value;
        $site = Site::findOrFail($id);

        $array = [
            'sites' => [$site->domain],
            'typeSites' => $site->type,
            'callback' => route('sites.api_testback')
        ];

        $query = Http::post($apiUrl, $array);
        return redirect()->route('sites.list')->with('message', "Сайт <strong>$site->domain</strong> отправлен на проверку. Результаты тестов будут доступны через несколько минут.");
    }

    public function api_list()
    {
        $result = [];
        $sites = Site::all()->toArray();
        foreach ($sites as $site) {
            $array = [
                'id' => $site['id'],
                'domain' => $site['domain'],
                'type' => $site['type'],
                'last_test' => $site['last_test'],
                'last_check' => $site['last_check'],
            ];
            $result[] = $array;
        }
        return $result;
    }

    public function api_testback(Request $request)
    {
        $array = $request->toArray();
        $domain = SitesHelper::getCleanDomain(array_key_first($array));
        
        $site = Site::where('domain', $domain)->first();
        
        if (!$site) {
            return response()->json([
                'status' => 'error',
                'message' => 'Domain not found.'
            ]);
        }

        // сохраняю состояние теста в таблице с сайтами
        $result = $array[array_key_first($array)];
        $site->last_test = time();
        $site->test_result = $result['passed'];
        $site->save();

        // создаю новую запись в таблице с результатами тестов
        $test = new TestResult();
            $test->site_id = $site->id;
            $test->result = json_encode($array);
        $test->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Tests result was saved.'
        ]);
    }

    public function tests($id)
    {
        $tests = TestResult::where('site_id', $id)->get();
        return view('sites.tests.index', compact('tests', 'id'));
    }

    public function api_available(Request $request)
    {        
        $domain = SitesHelper::getCleanDomain($request->domain);
        $available = $request->available;

        $site = Site::where('domain', $domain)->first();
        if (!$site) {
            return response()->json([
                'status' => 'error',
                'message' => 'Domain not found.'
            ]);
        }

        $site->available = $available;
        $site->status = $available;
        $site->last_check = time();
        $site->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Site status was saved.'
        ]);
    }
}
