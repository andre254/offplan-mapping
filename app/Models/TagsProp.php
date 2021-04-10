<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 09:40:41 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TagsProp
 * 
 * @property int $entry_id
 * @property int $tags_id
 * @property int $prop_id
 *
 * @package App\Models
 */
class TagsProp extends Eloquent
{
	protected $table = 'tags_prop';
	protected $primaryKey = 'entry_id';
	public $timestamps = false;

	protected $casts = [
		'tags_id' => 'int',
		'prop_id' => 'int'
	];

	protected $fillable = [
		'tags_id',
		'prop_id'
	];
}
