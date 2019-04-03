<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';
    
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id');
    }
    public function state()
    {
        return $this->belongsTo('App\Models\State','state_id');
    }
    public function cityObj()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }
    public function companyObj()
    {
        return $this->belongsTo('App\Models\Company','company_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
    public function industry()
    {
        return $this->belongsTo('App\Models\Industry');
    }
    
    
    public function photo()
    {
        return $this->hasMany('App\Models\Photo', 'facility_id');
    }
    public function featuredPhoto()
    {
        return $this->hasOne('App\Models\Photo');
    }
}
