<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industries';
    
    public function category() {
        return $this->belongsToMany('App\Models\Category','industries_categories');
    }
}
