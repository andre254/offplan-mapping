<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 09:40:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TagsBlog
 * 
 * @property int $entry_id
 * @property int $tags_id
 * @property int $blog_id
 *
 * @package App\Models
 */
class TagsBlog extends Eloquent
{
	protected $table = 'tags_blog';
	protected $primaryKey = 'entry_id';
	public $timestamps = false;

	protected $casts = [
		'tags_id' => 'int',
		'blog_id' => 'int'
	];

	protected $fillable = [
		'tags_id',
		'blog_id'
	];
}
