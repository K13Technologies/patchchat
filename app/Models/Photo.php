<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    
    const TYPE_MANAGEMENT = 1;
    const TYPE_USERS = 2;
    
    const STATUS_ACTIVE = 0;
    
    public function facility()
    {
        return $this->belongsTo('App\Models\Facility','facility_id');
    }
}
