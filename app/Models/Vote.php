<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'owner',
		'vote',
		'post',
		'reply'
	];

	public function post()
	{
		return $this->belongsTo(Posts::class, 'post');
	}

	public function reply()
	{
		return $this->belongsTo(Reply::class, 'reply');
	}
}
