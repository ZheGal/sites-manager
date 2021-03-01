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
            $sites = Site::where('campaign_id', $id);
            $all[$id] = $sites->get()->count();
        }
        return $all;
    }

    public static function get_offer_name($list, $id)
    {
        foreach ($list as $offer) {
            $offer_id = $offer->id;
            if ($offer_id == $id) {
                return $offer->languages[0]->alpha3 . ' - ' . $offer->name;
            }
        }
        return false;
    }
}