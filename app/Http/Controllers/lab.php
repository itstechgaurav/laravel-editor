<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class lab extends Controller
{
    //

    public function lab() {
        $email = "myselfgroOT@gmail.com";
        $username = explode("@", $email)[0];
        $allUsers = User::where('username', '=', $username)->count();
        if($allUsers) {
            $username = $username . $allUsers;
        }
        echo $username;
    }
}
