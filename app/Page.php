<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	protected $fillable = ['title', 'body', 'slug', 'user_id'];

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}