<?php

namespace App\Traits;

trait WithBuilder
{
    public function scopeFetch($query, $paginate = false, int $limit = 10)
    {
        $sort = request()->sort ?? 'desc';
        $query = $query->orderBy('created_at', $sort)->orderBy('id', $sort);

        if ($paginate) {
            return $query->paginate($limit)->withQueryString();
        }

        return $query->get();
    }
}
