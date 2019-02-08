<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    //

    public function file() {
        return $this->hasOne('App\file', 'project_slug', 'slug');
    }

    public function user() {
        return $this->hasOne('App\User', 'username', 'username');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

    public function likes() {
        return $this->hasMany('App\Like');
    }

    public function liked() {
        return $this->hasOne('App\Like');
    }

}
