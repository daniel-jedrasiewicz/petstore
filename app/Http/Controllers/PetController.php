<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetController extends Controller
{
    public $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index(Request $request): View
    {
        $status = $request->input('status', 'available');

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', config('app.pet_api_url').'/findByStatus', [
                'query' => [
                    'status' => $status,
                ],
            ]);

        } catch (RequestException $ex) {
            abort(404, 'Żądanie API nie powiodło się');
        }

        $data = json_decode($response->getBody(), true);

        $pets = $this->petService->paginate($data, $request);

        return view('pets.index', compact('pets', 'status'));
    }


}
