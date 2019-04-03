<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Industry;
use App\Models\Facility;
use App\Models\Country;

use Cache;
use App;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function welcome()
    {
        
        $total = $this->_total();
        return view('welcome', compact('total'));
        
    }
    
    public function home()
    {
        return view('home');        
    }
    
    private function _total() {
        $total = Cache::remember('facilities.count.total', 24*60, function() {
            return Facility::all()->count();
        });
        return $total;
    }
    
    public function industry(Industry $industry)
    {
        if(!$industry->id) {
            abort(404);
        }
        
        $total = $this->_total();
        $cacheKey = 'facilities.'.App::GetLocale().'.'.$industry->slug.'.count';
        $count = Cache::get($cacheKey);
        
        if(!isset($count)) {
            $q = Facility::where(['industry_id'=>$industry->id]);        
            $locale = explode("_",App::GetLocale());
            if(sizeOf($locale)>1) {
                $country = Country::where('slug', $locale[1])->first();
                $q->where('country_id', '=', $country->id);
            }
            $count = $q->count();
            Cache::put($cacheKey, $count, 24*60);
        }
               
        return view('industry/'.$industry->slug, compact('count','total','industry'));    
    }
    
    public function community(Industry $industry = null)
    {          
        return view('industry/community', compact('industry'));    
    }
    
    public function industryCommunities()
    {          
        $industries = Industry::all();
        return view('industry/communities', compact('industries'));    
    }
}
