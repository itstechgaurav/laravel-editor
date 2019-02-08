<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    //
    public function prject() {
       return $this->belongsTo('App\project');
    }
}
