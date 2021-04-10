<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 09:37:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Tag
 * 
 * @property int $tags_id
 * @property string $tag_name
 *
 * @package App\Models
 */
class Tag extends Eloquent
{
	protected $primaryKey = 'tags_id';
	public $timestamps = false;

	protected $fillable = [
		'tag_name'
	];
}
