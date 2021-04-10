<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 03 Aug 2017 05:50:26 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Promonewproject
 * 
 * @property int $pronew_id
 * @property string $pronew_name
 * @property string $pronew_slug
 * @property string $pronew_blurb
 * @property string $pronew_description
 * @property string $pronew_properties
 * @property int $pronew_type
 * @property int $pronew_dev
 * @property \Carbon\Carbon $pronew_date_up
 *
 * @package App\Models
 */
class Promonewproject extends Eloquent
{
	protected $table = 'promonewproject';
	protected $primaryKey = 'pronew_id';
	public $timestamps = false;

	protected $casts = [
		'pronew_type' => 'int',
		'pronew_dev' => 'int'
	];

	protected $dates = [
		'pronew_date_up'
	];

	protected $fillable = [
		'pronew_name',
		'pronew_blurb',
		'pronew_slug',
		'pronew_properties',
		'pronew_type',
		'pronew_dev',
		'pronew_date_up'
	];

	public function isActive($id){
		if($this->where('pronew_slug',$id)->where('pronew_status',1)->first()){
			return true;
		}else{
			return false;
		}
	}
	public function getBySlug($id){
		return $this->where('pronew_slug',$id)->where('pronew_status',1)->first();
	}
}
