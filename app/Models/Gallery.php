<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Apr 2017 06:18:23 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class NldpGallery
 * 
 * @property int $gal_id
 * @property string $gal_name
 * @property string $gal_image_ids
 *
 * @package App\Models
 */
class Gallery extends Eloquent
{
	protected $table = 'gallery';
	protected $primaryKey = 'gal_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'gal_id' => 'int'
	];

	protected $fillable = [
		'gal_name',
		'gal_image_ids',
		'gal_desc'
	];
}
