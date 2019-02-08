<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role();
        $role->name = "Admin";
        $role->image = "/img/admin-role.jpg";
        $role->meta = "The Boss";
        $role->save();

        $role = new Role();
        $role->name = "subscriber";
        $role->image = "/img/default-role.jpg";
        $role->meta = "A Normal User";
        $role->save();
    }
}
