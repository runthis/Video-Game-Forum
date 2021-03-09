<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'owner',
		'ip',
		'subject',
		'body',
		'link'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'owner');
	}

	public function reply()
	{
		return $this->hasMany(Reply::class, 'post');
	}

	public function getBodyAttribute($value)
	{
		return nl2br(htmlentities($value, ENT_QUOTES, 'UTF-8'));
	}
}
