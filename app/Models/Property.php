<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 01 Apr 2018 06:42:25 +0000.
 */

namespace App\Models;
use Illuminate\Support\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Property
 * 
 * @property int $prop_id
 * @property string $prop_name
 * @property string $prop_slug
 * @property int $prop_developer
 * @property string $prop_community
 * @property int $prop_location
 * @property int $prop_bed
 * @property int $prop_bed_null
 * @property string $prop_type
 * @property string $prop_content
 * @property string $prop_featured_image
 * @property string $prop_video
 * @property int $prop_gallery
 * @property int $prop_floorplan
 * @property int $prop_status
 * @property string $prop_meta_key
 * @property string $prop_meta_desc
 * @property string $prop_meta_title
 * @property float $prop_price
 * @property float $prop_area
 * @property \Carbon\Carbon $prop_date_up
 * @property \Carbon\Carbon $prop_date_fin
 * @property int $prop_date_null
 * @property string $prop_code
 * @property string $prop_file_ids
 * @property string $prop_map
 *
 * @package App\Models
 */
class Property extends Eloquent
{
	protected $table = 'property';
	protected $primaryKey = 'prop_id';
	public $timestamps = false;

	protected $casts = [
		'prop_developer' => 'int',
		'prop_location' => 'int',
		'prop_bed' => 'int',
		'prop_bed_null' => 'int',
		'prop_gallery' => 'int',
		'prop_floorplan' => 'int',
		'prop_status' => 'int',
		'prop_price' => 'float',
		'prop_area' => 'float',
		'prop_date_null' => 'int'
	];

	protected $dates = [
		'prop_date_up',
		'prop_date_fin'
	];

	protected $fillable = [
		'prop_name',
		'prop_slug',
		'prop_developer',
		'prop_community',
		'prop_location',
		'prop_bed',
		'prop_bed_null',
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
		'prop_area',
		'prop_date_up',
		'prop_date_fin',
		'prop_date_null',
		'prop_code',
		'prop_file_ids',
		'prop_map',
		'prop_lat',
		'prop_long',
	];
	public function isActive($slug){
		if($this->where('prop_slug',$slug)->where('prop_status',1)->count() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function getActiveByLoc($loc){
		return $this->orderby('prop_date_up','desc')->where('prop_location',$loc)->whereIn('prop_status',[1])->get();
	}
	public function getByDeveloper($slug){
		return $this->orderby('prop_date_up','desc')->where('prop_developer',$slug)->whereIn('prop_status',[1])->get();
		
	}
	public function getActiveAll(){
		return $this->orderby('prop_date_up','desc')->whereIn('prop_status',[1])->get();
	}

	public function featured(){
		 return $this->belongsTo('App\Models\GalleryImage', 'prop_featured_image', 'img_id');
	}

	public function location(){
		 return $this->belongsTo('App\Models\Location', 'prop_location', 'loc_id');
	}
}
