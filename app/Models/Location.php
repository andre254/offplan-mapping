<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Apr 2017 06:18:23 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class NldpLocation
 * 
 * @property int $loc_id
 * @property string $loc_name
 * @property string $loc_desc
 * @property string $loc_img
 *
 * @package App\Models
 */
class Location extends Eloquent
{
	protected $table = 'location';
	protected $primaryKey = 'loc_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'loc_id' => 'int'
	];

	protected $fillable = [
		'loc_name',
		'loc_slug',
		'loc_desc',
		'loc_img'
	];
	public function exists($slug){
		if($this->where('loc_slug',$slug)->count() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function getLocId($slug){
		return $this->where('loc_slug',$slug)->pluck('loc_id')->first();
	}
	public function getLocName($slug){
		return $this->where('loc_slug',$slug)->pluck('loc_name')->first();
	}
	
	public function property(){
		  return $this->hasMany('App\Models\Property', 'loc_id', 'prop_location');
	}
}
