<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 14 May 2017 11:53:00 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class File
 * 
 * @property int $file_id
 * @property string $file_name
 * @property string $file_path
 * @property \Carbon\Carbon $file_date_uploaded
 *
 * @package App\Models
 */
class File extends Eloquent
{
	protected $primaryKey = 'file_id';
	public $timestamps = false;

	protected $dates = [
		'file_date_uploaded'
	];

	protected $fillable = [
		'file_name',
		'file_path',
		'file_date_uploaded'
	];
}
