<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'owner',
		'ip',
		'post',
		'body'
	];

	public function post()
	{
		return $this->belongsTo(Posts::class, 'post');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'owner');
	}

	public function getBodyAttribute($value)
	{
		return nl2br(htmlentities($value, ENT_QUOTES, 'UTF-8'));
	}
}
