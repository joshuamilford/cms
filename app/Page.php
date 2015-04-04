<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	protected $fillable = ['title', 'body', 'slug', 'user_id', 'parent_id'];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function tags()
	{
		return $this->belongsToMany('App\Tag')->withTimestamps();
	}

	public function parent()
	{
		return $this->hasOne('App\Page', 'id', 'parent_id');
	}

	public function children()
	{
		return $this->hasMany('App\Page', 'parent_id', 'id');
	}
}
