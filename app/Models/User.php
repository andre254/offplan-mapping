<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 09:37:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $country
 * @property string $remember_token
 * @property string $reference
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $level
 *
 * @package App\Models
 */
class User extends Eloquent
{
	protected $casts = [
		'level' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'mobile',
		'country',
		'remember_token',
		'reference',
		'level'
	];
}
