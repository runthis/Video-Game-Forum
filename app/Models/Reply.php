<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	use HasFactory;

	protected $table = 'replies';

	public function post()
	{
		return $this->belongsTo(Posts::class, 'post');
	}
}
