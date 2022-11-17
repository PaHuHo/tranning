<?php

namespace Database\Seeders;

use App\Models\MstShop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ["Amazon", "Yahoo", "Rakuten"];
        foreach ($array as $shopName) {
            $shop = new MstShop();
            $shop->shop_name = $shopName;
            $shop->save();
        }
    }
}
