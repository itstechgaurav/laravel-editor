<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Profile;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Admin User";
        $user->email = "admin@admin.com";
        $user->role_id = 1;
        $user->username = "admin";
        $user->password = bcrypt($user->email);
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->meta = "I am Admin User";
        $profile->save();

        $user = new User();
        $user->name = "Test User";
        $user->email = "test@test.com";
        $user->role_id = 1;
        $user->username = "test";
        $user->password = bcrypt($user->email);
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->meta = "I am Test User";
        $profile->save();

        $user = new User();
        $user->name = "Public User";
        $user->email = "public@public.com";
        $user->username = "public";
        $user->password = bcrypt($user->email);
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->meta = "I am Public User";
        $profile->save();
    }
}
