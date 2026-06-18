<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;

if (! function_exists('collectPaginate')) {
    function collectPaginate(LengthAwarePaginator $data, string $resourceClass): LengthAwarePaginator
    {
        $data->getCollection()->transform(fn (mixed $item): mixed => $resourceClass::make($item));

        return $data;
    }
}
