<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 16 May 2017 13:14:22 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PropertyListing
 * 
 * @property int $list_id
 * @property string $list_fname
 * @property string $list_lname
 * @property string $list_phone
 * @property string $list_email
 * @property string $list_location
 * @property string $list_sub_location
 * @property string $list_prop_type
 * @property string $list_contract_type
 * @property int $list_bed
 * @property int $list_bath
 * @property int $list_area
 * @property float $list_plot
 * @property float $list_price
 * @property string $list_notes
 * @property int $list_status
 * @property \Carbon\Carbon $list_date_up
 *
 * @package App\Models
 */
class PropertyListing extends Eloquent
{
	protected $table = 'property_listing';
	protected $primaryKey = 'list_id';
	public $timestamps = false;

	protected $casts = [
		'list_bed' => 'int',
		'list_bath' => 'int',
		'list_area' => 'int',
		'list_plot' => 'float',
		'list_price' => 'float',
		'list_status' => 'int'
	];

	protected $dates = [
		'list_date_up'
	];

	protected $fillable = [
		'list_fname',
		'list_lname',
		'list_phone',
		'list_email',
		'list_location',
		'list_sub_location',
		'list_prop_type',
		'list_contract_type',
		'list_bed',
		'list_bath',
		'list_area',
		'list_plot',
		'list_price',
		'list_notes',
		'list_status',
		'list_date_up'
	];
}
