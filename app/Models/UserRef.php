<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 09:38:01 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserRef
 * 
 * @property int $entry_ref
 * @property string $ref_id
 * @property string $user_id
 *
 * @package App\Models
 */
class UserRef extends Eloquent
{
	protected $primaryKey = 'entry_ref';
	public $timestamps = false;

	protected $fillable = [
		'ref_id',
		'user_id'
	];
}
