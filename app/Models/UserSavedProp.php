<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 09:38:11 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserSavedProp
 * 
 * @property int $saved_id
 * @property string $user_id
 * @property string $prop_code
 *
 * @package App\Models
 */
class UserSavedProp extends Eloquent
{
	protected $primaryKey = 'saved_id';
	public $timestamps = false;

	protected $fillable = [
		'user_id',
		'prop_code'
	];
}
