<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use PHPExcel_IOFactory;

use App\Models\Category;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Facility;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patchchat:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Patchchat facilities import from xls file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /*public function getOptions() {
        return [
            ['filename', '-f', InputOption::REQUIRED, 'Excel file to import', null]
        ];
    }*/
    
    /*public function getOptions() {
        return [
            ['filename', 'f', InputOption::REQUIRED, 'Excel file to import', null]
        ];
    }
*/
    public function getArguments() {
        return [
            ['filename', InputArgument::REQUIRED, 'Excel file to import']
        ];
    }
    
    

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $filename = "SAGD Facilities.xlsx";
        
        $inputDir = 'C:\Users\Bambr\Dropbox\Projects\PatchChat\xmls';
        $dirHandle = opendir($inputDir);
        while($filename = readdir($dirHandle)) {
            if(preg_match('/\.xlsx?$/', $filename)) {
                $inputFileName =  $inputDir . '\\'. $filename;
                
                $this->info("==== $filename ====");
                
                //  Read your Excel workbook
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    $this->error('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' . $e->getMessage());
                }
                
                //  Get worksheet dimensions
                
                $worksheets = $objPHPExcel->getSheetNames();
                $this->info("Worksheets found:");
                //$this->info(print_r($worksheets,1));        
                foreach($worksheets as $worksheet => $worksheetName) {
                    $this->info("Worksheet $worksheet: $worksheetName");
                    
                    // try to guess country and province
                    $state = $country = null;
                                
                    //$worksheet = $this->ask("Enter worksheet number");
                    $country = Country::where('name', $worksheetName)->first();
                    if($country && $country->id) {
                        $this->info("Country found: ".$country->name);              
                        $state = State::where(array('code' => 'NA','country_id'=>$country->id))->first();
                        if($state && $state->id) {
                            $this->info("State found: ".$state->name);
                        } else {
                            $state = new State;
                            $state->name = 'NA';
                            $state->slug =  $country->slug."/".'NA';
                            $state->code =  'NA';
                            $state->country()->associate($country);
                            $state->save();
                        }
                                         
                    }
                    
                    if(!$state) {
                        $state = State::where(array('name' => $worksheetName))->first();
                        if($state and $state->id) {
                            $this->info("State found: ".$state->name);
                            $country = $state->country;
                            $this->info("Country matched: ".$country->name);
                        }
                    }
                    
                    if($country) { 
                        $countryCode = $country->slug; 
                    }
                    if($state) { 
                        $stateCode = $state->code; 
                    }
                
                    if(!$country || !$state) {
                        if(!$country) {
                            $countryCode = $this->ask('What is Country (code)?');
                            $country = Country::where('slug', $countryCode)->first();
                            if($country and $country->id) {
                            
                            } else {
                                $countryName = $this->ask("That's new! What is Country name?");
                            
                                $country = new Country;
                                $country->name = $countryName;
                                $country->slug =  $countryCode;
                                $country->save();
                                $this->info("Country Created, ID " . $country->id);
                            }
                        }
                        $stateCode = $this->ask('What is State (code)');
                        $state = State::where(array('slug' => $countryCode.'/'.$stateCode, "country_id" => $country->id))->first();
                        if($state and $state->id) {
                        
                        } else {
                            $stateName = $this->ask("That's new! What is State name");
                        
                            $state = new State;
                            $state->name = $stateName;
                            $state->slug =  $countryCode."/".$stateCode;
                            $state->code =  $stateCode;
                            $state->country()->associate($country);
                            $state->save();
                            $this->info("State Created, ID " . $state->id);
                        }
                    }
                    
                    $sheet = $objPHPExcel->getSheet($worksheet);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    
                    list($columns) = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
                    //print_r($columns);
                    
                    $columnsMap = [];
                    foreach($columns as $key => $name) {
                        if(preg_match('/camp|type|category/i',$name)) {
                            $columnsMap['category'] = $key;
                        } elseif(preg_match('/owner/i',$name)) {
                            $columnsMap['company'] = $key;
                        } elseif(preg_match('/\b(lsd|api)\b/i',$name)) {
                            $columnsMap['lsd'] = $key;
                        } elseif(preg_match('/lat/i',$name) and preg_match('/long/i',$name)) {
                            $columnsMap['latlng'] = $key;
                        } elseif(preg_match('/latitude/i',$name)) {
                            $columnsMap['latitude'] = $key;
                        } elseif(preg_match('/longitude/i',$name)) {
                            $columnsMap['longitude'] = $key;
                        } elseif(preg_match('/address/i',$name)) {
                            $columnsMap['address'] = $key;                           
                        } elseif(preg_match('/emergency/i',$name)) {
                            $columnsMap['phone_emergency'] = $key;                        
                        } elseif(preg_match('/reservation/i',$name)) {
                            $columnsMap['phone_reservations'] = $key;
                        } elseif(preg_match('/fax/i',$name)) {
                            $columnsMap['fax'] = $key;
                        } elseif(preg_match('/main|phone/i',$name)) {
                            $columnsMap['phone_main'] = $key;
                        } elseif(preg_match('/cell/i',$name)) {
                            $columnsMap['phone_cell'] = $key;
                        } elseif(preg_match('/email/i',$name)) {
                            $columnsMap['email'] = $key;
                        } elseif(preg_match('/website|url/i',$name)) {
                            $columnsMap['website'] = $key;
                        } elseif(preg_match('/direction/i',$name)) {
                            $columnsMap['directions'] = $key;
                        } elseif(preg_match('/city/i',$name)) {
                            $columnsMap['city'] = $key;
                        } elseif(preg_match('/name/i',$name)) {
                            $columnsMap['name'] = $key;
                        } elseif(preg_match('/description/i',$name)) {
                            $columnsMap['description'] = $key;
                        } elseif(preg_match('/beds/i',$name)) {
                            $columnsMap['beds'] = $key;
                        }
                              
                    }       
                    $columnsMap['name'] = 0;
                    //print_r($columnsMap);
                    
                    
                    //  Loop through each row of the worksheet in turn
                    for ($row = 2; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,  NULL, TRUE, FALSE);
                        
                        try {
                        
                            // check category
                            $categoryName = $rowData[0][$columnsMap["category"]];
                            if(!$categoryName) {
                                $categoryName = preg_replace('/s?\.\w+$/','',$filename);
                            }
                            if($categoryName) {
                                $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i','-',$categoryName), '-'));
                                $category = Category::where('slug', $slug )->first();
                                if($category and $category->id) { 
                                    //$this->info("Category Found, ID " . $category->id);
                                } else {                    
                                    $category = new Category;                    
                                    $category->name = $categoryName;                    
                                    $category->slug =  strtolower(trim(preg_replace('/[^a-z0-9]+/i','-',$categoryName), '-'));
                                    $category->save();
                                    $this->info("Category Created, ID " . $category->id);
                                }                               
                            }
                
                            // check company
                            $companyName = $rowData[0][$columnsMap["company"]];
                            if($companyName) {
                                $company = company::where('name', $companyName)->first();
                                if($company and $company->id) {
                                    //$this->info("company Found, ID " . $company->id);
                                } else {
                                    $company = new Company;
                                    $company->name = $companyName;
                                    $company->slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i','-',$companyName),'-'));
                                    $company->save();
                                    $this->info("Company Created, ID " . $company->id);
                                }
                            }       
                                 
                            // check city
                            $cityName = preg_replace('/\s+/',' ',trim(preg_replace('/\(.*?\)/',' ',$rowData[0][$columnsMap["city"]])));
                            $citySlug = $countryCode."/".$stateCode."/".strtolower(trim(preg_replace('/[^a-z0-9]+/i','-',$cityName),'-'));
                            if($cityName) {
                                $city = City::where(array(
                                    'slug' => $citySlug
                                ))->first();
                                
                                if($city and $city->id) {
                                    //$this->info("company Found, ID " . $company->id);
                                } else {
                                    $city = new City;
                                    $city->name = $cityName;
                                    $city->slug = $citySlug;
                                    $city->country()->associate($country);
                                    $city->state()->associate($state);
                                    $city->save();
                                    $this->info("City Created, ID " . $city->id);
                                }
                            }
                            
                            $facilityName = $rowData[0][$columnsMap["name"]];
                            $facilitySlug = $countryCode."/".$stateCode."/".strtolower(trim(preg_replace('/[^a-z0-9]+/i','-',$facilityName),'-'));
                            if($facilityName) {
                                $facility = Facility::where(array(
                                    'slug' => $facilitySlug
                                ))->first();
                            
                                if($facility and $facility->id) {                    
                                    // update?
                                } else {
                                    $facility = new Facility;
                                    $facility->name = $facilityName;
                                    $facility->slug = $facilitySlug;
                                    $facility->country()->associate($country);
                                    $facility->state()->associate($state);
                                }
                                if(isset($city) and $city) {
                                    $facility->cityObj()->associate($city);
                                }
                                $facility->category()->associate($category);
                                $facility->industry()->associate($category->industry);
                                
                                if(isset($companyName) && $companyName) {
                                $facility->company = $companyName;
                                    if(isset($company) && $company) {
                                        $facility->companyObj()->associate($company);
                                    }
                                }
                                if(isset($columnsMap['lsd']) && $columnsMap['lsd']) {
                                    $facility->lsd = $rowData[0][$columnsMap['lsd']];
                                }
                                // latlng
                                if(isset($columnsMap['latlng']) && $columnsMap['latlng'] && $rowData[0][$columnsMap['latlng']]) {
                                    
                                    $parts = explode(",",trim($rowData[0][$columnsMap['latlng']],","));
                                    if(sizeOf($parts)>1) {
                                        list($lat,$lng) = $parts;
                                        //list($lng,$lat) = $parts;
                                    }
                                    if($lat && $lng) {
                                        $facility->latitude = $lat;
                                        $facility->longitude = $lng;
                                    }
                                } else if(isset($columnsMap['latitude']) && $columnsMap['latitude'] && isset($columnsMap['longitude']) && $columnsMap['longitude']) {
                                    $facility->latitude = trim(preg_replace("/^[a-z\:\s]*/i","",$rowData[0][$columnsMap['latitude']]),' ,.\'');
                                    $facility->longitude = trim(preg_replace("/^[a-z\:\s]*/i","",$rowData[0][$columnsMap['longitude']]),' ,.\'');
                                } 
                                $facility->latitude = preg_replace('/^.*?(\-?\d+\.\d*).*?$/','$1',$facility->latitude);
                                $facility->longitude = preg_replace('/^.*?(\-?\d+\.\d*).*?$/','$1',$facility->longitude);
                                if(!$facility->latitude or !$facility->longitude) {
                                    $facility->longitude = null;
                                    $facility->latitude = null;
                                }
                                // check if lat lng valid
                                if($facility->latitude > 90 or $facility->latitude < -90) {
                                    $tmp = $facility->latitude;
                                    $facility->latitude = $facility->longitude;
                                    $facility->longitude = $tmp;
                                    
                                }
                                
                                if(isset($columnsMap['address'])) {
                                    $facility->address = $rowData[0][$columnsMap['address']];
                                }
                                if(isset($columnsMap['phone_reservations'])) {
                                    $facility->phone_reservations = $rowData[0][$columnsMap['phone_reservations']];
                                }
                                if(isset($columnsMap['phone_emergency'])) {
                                    $facility->phone_emergency = $rowData[0][$columnsMap['phone_emergency']];
                                }
                                if(isset($columnsMap['phone_main'])) {
                                    $facility->phone_main = $rowData[0][$columnsMap['phone_main']];
                                }
                                if(isset($columnsMap['phone_cell'])) {
                                    $facility->phone_cell = $rowData[0][$columnsMap['phone_cell']];
                                }
                                if(isset($columnsMap['fax'])) {
                                    $facility->fax = $rowData[0][$columnsMap['fax']];
                                }
                                if(isset($columnsMap['email'])) {
                                    $facility->email = $rowData[0][$columnsMap['email']];
                                }
                                if(isset($columnsMap['website'])) {
                                    $facility->website = $rowData[0][$columnsMap['website']];
                                }
                                if(isset($columnsMap['directions'])) {
                                    $facility->directions = $rowData[0][$columnsMap['directions']];
                                }
                                if(isset($columnsMap['description'])) {
                                    $facility->description = $rowData[0][$columnsMap['description']];
                                }
                                if(isset($columnsMap['beds'])) {
                                    $facility->beds = $rowData[0][$columnsMap['beds']];
                                }
                                
                                
                                
                                $facility->save();
                                //$this->info("Facility updated, ID " . $facility->id);
                            }
                        } catch (\Exception $e) {
                            $this->info("Row $row error:" . $e->getMessage());
                        }           
                    } 
                //        echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />";
                }
            }
        }
    
    
    }
}
