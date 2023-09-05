<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PetService
{
    public function paginate($pets, $request, $perPage = 10): LengthAwarePaginator
    {
        $pets = collect($pets);
        $page = $request->input('page', 1);

        return new LengthAwarePaginator(
            $pets->forPage($page, $perPage),
            $pets->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}
