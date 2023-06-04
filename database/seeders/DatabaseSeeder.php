<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Commodity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'ahmad','email'=>'ahmad@gmail.com','password'=>Hash::make('ahmad1234')]);

        Commodity::create(['name'=>'گوشی' ,'price'=>'10000','amount'=>'12','body'=>'سامسونگ']);
        Commodity::create(['name'=>'هدفون' ,'price'=>'30000','amount'=>'33','body'=>'جی بی ال']);
        Commodity::create(['name'=>'مانیتور' ,'price'=>'230000','amount'=>'110','body'=>'ال جی']);
    }
}
