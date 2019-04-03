<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Facility;
use App\Models\Category;
use App\Models\Industry;

use Cache;

class MapController extends Controller
{
    
    public function index()
    {
        $industries = Industry::orderBy("name")->get(array("id","slug","name"));
        
        $categories = Category::orderBy("name")->get(array("id","slug","name","icon"));
        
        return view('map.index', compact('categories','industries'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function search()
    {                
        $response = Cache::remember('map.search.json', 24*60, function() {
            $q = Facility::where("status",0);
            $q->whereNotNull('latitude')
              ->whereNotNull('longitude');
            
//            $q->whereNot('state_id',7);
            
            $facilities = $q->get();
        
            $icons = [];
            $categories = Category::all(array("id","slug","name","icon"));
            foreach($categories as $category) {
                $icons[$category->id] = $category;
            }
            $results = [];
            
            foreach($facilities as $facility) {
                $results[] = [
                    'geometry' => [
                        'type' => "Point", 
                        'coordinates' => [$facility->longitude, $facility->latitude]
                    ],
                    'properties' => [
                        'name' => $facility->name, 
                        //'marker-color' => "#0000ff",
                        //'marker-symbol' => isset($icons[$facility->category_id]) ? $icons[$facility->category_id]->icon : 'cemetery',
                        'category' => isset($icons[$facility->category_id]) ? $icons[$facility->category_id]->name : 'Other',
                        'category_id' => $facility->category_id,
                        'slug' => $facility->slug,
                        'company' => $facility->company ? $facility->company : '',//<a href="/help/'.($facility->id).'/company">Do you know company name?</a>
                        "icon" => [
                            "iconSize" => [33, 33], // size of the icon
                            "iconAnchor" => [16, 16], // point of the icon which will correspond to marker's location
                            "popupAnchor" => [0, -16], // point from which the popup should open relative to the iconAnchor
                            "className" => "pcmi pcmi-" . (isset($icons[$facility->category_id]) ? $icons[$facility->category_id]->icon : 'other'),
                        ]
                    ],
                    'type' => "Feature"                
                ];
            }
                
            return [
                'type' => 'FeatureCollection',
                'categories' => $categories,
                'features' => $results                               
            ];            
        });        
        return response()->json($response);
    }

}
