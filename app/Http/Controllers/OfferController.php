<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Neogara;
use App\Helpers\Offers;

class OfferController extends Controller
{
    public function index()
    {
        $neo = new Neogara();
        $offers = $neo->get_offers();
        $count = Offers::count_sites($offers);
        
        return view('offers.list', ['offers' => $offers, 'count' => $count]);
    }
}
