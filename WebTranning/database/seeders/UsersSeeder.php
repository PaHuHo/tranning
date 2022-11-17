<?php

namespace Database\Seeders;

use App\Models\MstUsers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        MstUsers::truncate();
        Schema::enableForeignKeyConstraints();
        //
        $role=["Admin","Editor","Reviewer"];
        for($i=0;$i<100;$i++){
            MstUsers::create([
                'name' => 'Nhân viên '.($i+1),
                'email' => 'test'.($i+1).'@gmail.com',
                'password'=>Hash::make('123456'),
                'group_role' => $role[rand(0,2)],
                'is_active' => rand(0,1),
            ]);
        }
        // $user=new MstUsers();
        // $user->name="test";
        // $user->email="test@gmail.com";
        // $user->password=Hash::make('123456');
        // $user->group_role="test";
        // $user->save();
    }
}
