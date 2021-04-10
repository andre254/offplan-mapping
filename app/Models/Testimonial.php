<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 17 May 2017 08:44:26 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Testimonial
 * 
 * @property int $testimony_id
 * @property string $testimony_name
 * @property string $testimony_content
 * @property int $testimony_status
 * @property \Carbon\Carbon $testimony_date_up
 * @property string $testimony_email
 *
 * @package App\Models
 */
class Testimonial extends Eloquent
{
	protected $primaryKey = 'testimony_id';
	public $timestamps = false;

	protected $casts = [
		'testimony_status' => 'int'
	];

	protected $dates = [
		'testimony_date_up'
	];

	protected $fillable = [
		'testimony_name',
		'testimony_content',
		'testimony_status',
		'testimony_date_up',
		'testimony_email'
	];
}
