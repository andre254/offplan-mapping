<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 11 Apr 2017 06:07:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class NldpCustomerInquiry
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $project_name
 * @property string $message
 * @property \Carbon\Carbon $date_inquired
 *
 * @package App\Models
 */
class CustomerInquiry extends Eloquent
{
	public $timestamps = false;

	protected $dates = [
		'date_inquired'
	];

	protected $fillable = [
		'name',
		'email',
		'phone',
		'project_name',
		'message',
		'date_inquired'
	];
}
