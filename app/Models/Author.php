<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 22 May 2017 13:52:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Author
 * 
 * @property int $author_id
 * @property string $author_fname
 * @property string $author_lname
 * @property string $author_img
 * @property int $author_gender
 * @property string $author_desc
 * @property string $author_slug
 * @property \Carbon\Carbon $author_date_up
 *
 * @package App\Models
 */
class Author extends Eloquent
{
	protected $table = 'author';
	protected $primaryKey = 'author_id';
	public $timestamps = false;

	protected $casts = [
		'author_gender' => 'int'
	];

	protected $dates = [
		'author_date_up'
	];

	protected $fillable = [
		'author_fname',
		'author_lname',
		'author_email',
		'author_img',
		'author_desc',
		'author_slug',
		'author_date_up'
	];
}
