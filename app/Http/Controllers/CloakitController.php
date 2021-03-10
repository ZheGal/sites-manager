<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\Cloakit\Cloakit;
use App\Helpers\Neogara;
use App\Helpers\Offers;

class CloakitController extends Controller
{
    //
    public function index()
    {
        $app = new Cloakit();
        $campaign = $app->newcampaign();
        print_r($campaign);
        die;
    }

    public function new()
    {
        // вывести форму для регистрации новой клоаки
        $neo = new Neogara();
        $offers = $neo->get_offers();
        return view('cloakit.new', compact('offers'));
    }

    public function store(Request $request)
    {
        $results = [];
        $app = new Cloakit();
        $array = $request->all();
        $array = $app->get_clean_request($array);
        foreach ($array as $campaign) {
            $results[] = $app->newcampaign($campaign);
        }
        
        if (empty($results)) {
            return redirect()->route('cloakit.index')->with('message', "Список сайтов пустой.");
        }
        return view('cloakit.success', compact('results'));
    }
}
