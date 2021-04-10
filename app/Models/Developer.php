<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Apr 2017 06:18:23 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class NldpDeveloper
 * 
 * @property int $dev_id
 * @property string $dev_name
 * @property string $dev_desc
 * @property string $dev_image
 *
 * @package App\Models
 */
class Developer extends Eloquent
{
	protected $table = 'developer';
	protected $primaryKey = 'dev_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'dev_id' => 'int'
	];

	protected $fillable = [
		'dev_name',
		'dev_slug',
		'dev_desc',
		'dev_image'
	];
	public function isActive($slug){
		if($this->where('dev_slug',$slug)->first()){
			return true;
		}else{
			return false;
		}
	}
}
