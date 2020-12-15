<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new User();
        $user->name="Nawa Durga";
        $user->phone="9800916365";
        $user->password=bcrypt('admin');
        $user->role=0;
        $user->address="Ramailo, Morang";
        $user->save();
    }
}
