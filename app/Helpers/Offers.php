<?php

namespace App\Helpers;

use App\Models\Site;

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
                $sites = Site::where('campaign_id', $id);
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
}