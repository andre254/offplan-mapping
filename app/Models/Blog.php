<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 22 May 2017 12:44:15 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Blog
 * 
 * @property int $blog_id
 * @property string $blog_title
 * @property string $blog_slug
 * @property int $blog_status
 * @property string $blog_author
 * @property string $blog_content
 * @property \Carbon\Carbon $blog_date_up
 *
 * @package App\Models
 */
class Blog extends Eloquent
{
	protected $table = 'blog';
	protected $primaryKey = 'blog_id';
	public $timestamps = false;

	protected $casts = [
		'blog_status' => 'int'
	];

	protected $dates = [
		'blog_date_up'
	];

	protected $fillable = [
		'blog_title',
		'blog_slug',
		'blog_status',
		'blog_author',
		'blog_content',
		'blog_date_up'
	];
	public function isActive($slug){
		if($this->where('blog_slug',$slug)->where('blog_status',1)->first()){
			return true;
		}else{
			return false;
		}
	}
}
