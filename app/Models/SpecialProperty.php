<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 31 May 2017 10:21:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SpecialProperty
 * 
 * @property int $sprop_id
 * @property string $sprop_name
 * @property string $sprop_slug
 * @property string $sprop_properties
 * @property string $sprop_image
 * @property int $sprop_dev
 * @property int $sprop_location
 * @property string $sprop_description
 * @property \Carbon\Carbon $sprop_date_up
 * @property int $sprop_status
 *
 * @package App\Models
 */
class SpecialProperty extends Eloquent
{
	protected $table = 'special_property';
	protected $primaryKey = 'sprop_id';
	public $timestamps = false;

	protected $casts = [
		'sprop_dev' => 'int',
		'sprop_location' => 'int',
		'sprop_status' => 'int'
	];

	protected $dates = [
		'sprop_date_up'
	];

	protected $fillable = [
		'sprop_name',
		'sprop_slug',
		'sprop_properties',
		'sprop_image',
		'sprop_bg',
		'sprop_dev',
		'sprop_location',
		'sprop_description',
		'sprop_date_up',
		'sprop_status'
	];

	public function isActive($id){
		if($this->where('sprop_slug',$id)->where('sprop_status',1)->first()){
			return true;
		}else{
			return false;
		}
	}
	public function getBySlug($id){
		return $this->where('sprop_slug',$id)->where('sprop_status',1)->first();
	}
}
