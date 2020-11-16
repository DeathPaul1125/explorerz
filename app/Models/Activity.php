<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    public function thematics(){
        return $this->belongsToMany('App\Models\Thematic')->withTimestamps();
    }
}
