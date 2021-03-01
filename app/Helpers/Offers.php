<?php

namespace App\Helpers;

use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class Offers
{
    public static function count_sites($list)
    {
        $all = [];
        foreach ($list as $site) {
            $id = $site->id;
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $sites = Site::where('campaign_id', $id);
            } else {
                $sites = Site::where('campaign_id', $id)->where('user_id', Auth::user()->id);
            }
            $all[$id] = $sites->get()->count();
        }
        return $all;
    }

    public static function get_offer_name($list, $id)
    {
        foreach ($list as $offer) {
            if (isset($offer->id) && $offer->id == $id) {
                return $offer->languages[0]->alpha3 . ' - ' . $offer->name;
            }
        }
        return false;
    }

    public static function only_users_offers($offers, $count)
    {
        $result = [];
        foreach ($count as $id => $num) {
            if ($num > 0) {
                $result[] = $offers[$id - 1];
            }
        }
        return collect($result);
    }
}