<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Property;

class MigrationsController extends Controller
{
    public function location(){
        abort('404');
    }

    public function property(){
        //coordinate migration for proximity search
        $coords = Property::get(['prop_map','prop_id']);

        foreach ($coords as $key => $value) {
            if ($value->prop_map) {
                $c = explode(',', $value->prop_map);
                $longlat = Property::find($value->prop_id);

                $longlat->prop_lat = $c[0];
                $longlat->prop_long = $c[1];

                $longlat->save();
                print_r($c);echo "<br />";
            }
        }
    }

    public function migrator(Property $p){
        $coords = $p->select('prop_map','prop_id')->get();
        try {
            foreach ($coords as $k => $v) {
                $c = explode(',',$v->prop_map);
                $tp = Property::find($v->prop_id);

                $tp->prop_lat = $c[0];
                $tp->prop_long = $c[1];

                $tp->save();

                if ($tp) {
                    echo "success <br />";
                }else{
                    echo "{$v->prop_id} - not updated";
                }
            }
        } catch (\Exception $e) {
            echo "<pre> {$e}";
        }
    }
}
