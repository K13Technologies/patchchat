<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
     
    public function industry()
    {
        return $this->belongsToMany('App\Models\Industry','industries_categories','category_id','industry_id');
    }
}
