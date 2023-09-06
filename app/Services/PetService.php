<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PetService
{
    public function paginate(array $pets, Request $request, int $perPage = 10): LengthAwarePaginator
    {
        $pets = collect($pets);
        $pets = $pets->sortByDesc('id');
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
