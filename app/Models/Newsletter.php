<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Jun 2017 14:05:29 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Newsletter
 * 
 * @property int $news_id
 * @property string $news_email
 * @property \Carbon\Carbon $news_date_up
 *
 * @package App\Models
 */
class Newsletter extends Eloquent
{
	protected $table = 'newsletter';
	protected $primaryKey = 'news_id';
	public $timestamps = false;

	protected $dates = [
		'news_date_up'
	];

	protected $fillable = [
		'news_email',
		'news_date_up'
	];
}
