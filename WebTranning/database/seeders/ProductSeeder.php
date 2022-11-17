<?php

namespace Database\Seeders;

use App\Models\MstProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        MstProduct::truncate();
        Schema::enableForeignKeyConstraints();
        
    //     $datas = [
    //         ['S0000000001', 'Sản phẩm A'],
    //         ['S0000000002', 'Sản phẩm B'],
    //         ['S0000000003', 'Sản phẩm C'],
    //         ['S0000000004', 'Sản phẩm D'],
    //         ['S0000000005', 'Sản phẩm E'],
    //         ['S0000000006', 'Sản phẩm F'],
    //         ['S0000000007', 'Sản phẩm G'],
    //         ['S0000000008', 'Sản phẩm H'],
    //         ['S0000000009', 'Sản phẩm ABC'],
    //         ['S0000000010', 'Sản phẩm BC'],
    //    ];
    //    foreach ($datas as $data) {
    //     MstProduct::create([
    //         'product_id' => $data[0],
    //         'product_name' => $data[1],
    //         'product_price' => rand(10,100),
    //         'is_sales' => rand(0,1)
    //     ]);}
        for($i=0;$i<100;$i++){
            MstProduct::create([
                'product_id' => 'SP '.($i+1),
                'product_name' => 'Sản phẩm '.($i+1),
                'product_price' => rand(10,100),
                'is_sales' => rand(0,1)
            ]);
        }
    }
}
