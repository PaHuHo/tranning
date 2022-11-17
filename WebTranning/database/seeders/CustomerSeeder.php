<?php

namespace Database\Seeders;

use App\Models\MstCustomer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        MstCustomer::truncate();
        Schema::enableForeignKeyConstraints();
        //
        $role=["Admin","Editor","Reviewer"];
        for($i=0;$i<100;$i++){
            MstCustomer::create([
                'customer_name' => 'Khách hàng '.($i+1),
                'email' => 'customer'.($i+1).'@gmail.com',
                'tel_num'=>'0903'.substr("0000000", strlen($i + 1)) . ($i + 1),
                'address' => Str::random(20),
                'is_active' => rand(0,1),
            ]);
        }
    }
}
