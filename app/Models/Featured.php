<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 03 Aug 2017 05:50:43 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Featured
 * 
 * @property string $propfeat
 * @property \Carbon\Carbon $date_up
 * @property int $feat_type
 *
 * @package App\Models
 */
class Featured extends Eloquent
{
	protected $table = 'featured';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'feat_type' => 'int'
	];

	protected $dates = [
		'date_up'
	];

	protected $fillable = [
		'propfeat',
		'date_up',
		'feat_type'
	];
}
