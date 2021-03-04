<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Hoster;
use App\Models\User;
use App\Helpers\Settings;
use App\Helpers\Flysystem;
use App\Helpers\SitesHelper;
use App\Helpers\UserHelper;
use App\Helpers\Neogara;
use App\Helpers\Offers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PrelandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = SitesHelper::getGetQueries($request);
        $search_domain = $request->query('search_domain');
        $neo = new Neogara();
        $offers = $neo->get_offers();
        $count = Offers::count_sites($offers);

        if (Auth::user()->role != 1 && Auth::user()->role != 2) {
            $offers = Offers::only_users_offers($offers, $count);
        }
        $offersMenu = Offers::linksForMenu($offers, $count);

        $sites = Site::orderBy('id', 'desc')->where('type', 'preland');
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

        return view('sites.prelands', compact('sites', 'search_domain', 'filters', 'offers', 'offersMenu'));
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
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
}
