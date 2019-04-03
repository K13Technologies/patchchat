<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Facility;
use App\Models\Industry;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;

use App;
use DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    public function search(Request $request, Industry $industry)
    {
        //
        $keywords = $request->query("keywords", null);
        $location = $request->query("location", null);
        
        $q = Facility::where("status",0);
        
        if($industry and $industry->id) {     
            $q->where('industry_id', '=',$industry->id);
        }
        
        $locale = explode("_",App::GetLocale());
        if(sizeOf($locale)>1) {
            $country = Country::where('slug', $locale[1])->first();
            $q->where('country_id', '=', $country->id);
        }
        
        if($keywords) {
            $q->where('name', 'like', '%'.$keywords.'%')
              ->orWhere('description', 'like', '%'.$keywords.'%');
        } 
        
        if($location) {
            if(preg_match('/(\-?\d+\.?\d*)[\s\,\:]+(\-?\d+\.?\d*)/',$location,$m)) {
                // lat / lng detected                
                $lat = $m[1];
                $lng = $m[2];
                //$q->select(DB::raw('( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(latitude) ) ) ) AS distance'));
                     
                //$q->where("( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(" . $lng . ") ) + sin( radians(" . $lat .") ) * sin( radians(latitude) ) ) ",'<',50);
                
            } else {            
                // try to find city
                $cityName = preg_replace('/\s+/',' ',trim(preg_replace('/\(.*?\)/',' ',$location)));
                
                $citiesQ = City::where(array(
                    'name' => $cityName
                ))->get();
                $cities = [];
                foreach($citiesQ as $city) {
                    $cities[] = $city->id;
                }
                $q->whereIn('city_id', $cities);
            }
        }
        
        $q->orderby("name");
        $facilities = $q->paginate(10);
        
        return view('search.search', compact('facilities','industry'));
    }
    
}
