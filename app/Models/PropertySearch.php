<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 25 May 2017 08:57:23 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class PropertySearch extends Eloquent
{
    protected $table = 'property';
    protected $primaryKey = 'prop_id';
    public $timestamps = false;

    protected $casts = [
        'prop_developer' => 'int',
        'prop_location' => 'int',
        'prop_gallery' => 'int',
        'prop_bed' => 'int',
        'prop_floorplan' => 'int',
        'prop_status' => 'int',
        'prop_price' => 'float'
    ];

    protected $dates = [
        'prop_date_up',
        'prop_date_fin'
    ];

    protected $fillable = [
        'prop_name',
        'prop_slug',
        'prop_developer',
        'prop_location',
        'prop_bed',
        'prop_type',
        'prop_content',
        'prop_featured_image',
        'prop_video',
        'prop_gallery',
        'prop_floorplan',
        'prop_status',
        'prop_meta_key',
        'prop_meta_desc',
        'prop_meta_title',
        'prop_price',
        'prop_date_up',
        'prop_date_fin',
        'prop_code',
        'prop_file_ids'
    ];
    public function isActive($slug){
        if($this->where('prop_slug',$slug)->where('prop_status',1)->count() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function getActiveByLoc($loc){
        return $this->where('prop_location',$loc)->whereIn('prop_status',[1])->get();
    }
    public function getByDeveloper($slug){
        return $this->where('prop_developer',$slug)->whereIn('prop_status',[1])->get();
        
    }
    public function getActiveAll(){
        return $this->whereIn('prop_status',[1])->get();
    }
}
