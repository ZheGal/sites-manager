<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Neogara;
use App\Helpers\Offers;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $neo = new Neogara();
        $offers = $neo->get_offers();
        $count = Offers::count_sites($offers);

        if (Auth::user()->role != 1 || Auth::user()->role != 2) {
            $offers = Offers::only_users_offers($offers, $count);
        }
        
        return view('offers.list', ['offers' => $offers, 'count' => $count]);
    }
}
