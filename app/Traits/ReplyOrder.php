<?php

namespace App\Traits;

trait ReplyOrder
{
	public function newQuery($ordered = true)
	{
		$query = parent::newQuery();

		if (empty($ordered)) {
			return $query;
		}

		return $query->orderBy('sticky', 'asc')->orderBy('created_at', 'desc');
	}
}
