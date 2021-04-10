<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 10 May 2017 11:06:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GalleryImage
 * 
 * @property int $img_id
 * @property string $img_name
 * @property string $img_file_name
 * @property string $img_desc
 * @property string $img_path
 * @property \Carbon\Carbon $img_uploaded
 *
 * @package App\Models
 */
class GalleryImage extends Eloquent
{
	protected $primaryKey = 'img_id';
	public $timestamps = false;

	protected $dates = [
		'img_uploaded'
	];

	protected $fillable = [
		'img_name',
		'img_file_name',
		'img_desc',
		'img_path',
		'img_uploaded'
	];

	public function featuredImage(){
		  return $this->hasMany('App\Models\Property', 'img_id', 'prop_featured_image');
	}
}
