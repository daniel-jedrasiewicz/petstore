<?php

namespace App\Http\Controllers;

use App\Enums\PetCategoryList;
use App\Enums\PetTag;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Jobs\StorePetJob;
use App\Services\PetService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetController extends Controller
{
    protected $petService;
    protected $client;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
        $this->client = new Client();
    }

    public function index(Request $request): View
    {
        $selectedStatus = $request->input('status', 'available');

        try {
            $response = $this->client->request('GET', config('app.pet_api_url') . '/findByStatus', [
                'query' => [
                    'status' => $selectedStatus,
                ],
            ]);

        } catch (RequestException $ex) {
            abort(404, 'Żądanie API nie powiodło się');
        }

        $data = json_decode($response->getBody(), true);

        $pets = $this->petService->paginate($data, $request);

        return view('pets.index', compact('pets', 'selectedStatus'));
    }

    public function edit($id)
    {
        try {
            $response = $this->client->request('GET', config('app.pet_api_url') . '/' . $id);

        } catch (RequestException $ex) {
            abort(404, 'Żądanie API nie powiodło się');
        }

        $pet = json_decode($response->getBody(), true);

        $selectedTags = [];

        if (isset($pet['tags']) && is_array($pet['tags'])) {
            $selectedTags = array_column($pet['tags'], 'id');
        }

        return view('pets.edit', compact('pet', 'selectedTags'));
    }
    public function create(): View
    {
        return view('pets.create');
    }
    public function store(StorePetRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'category' => json_decode($request->input('categoriesData'))[0],
            'status' => $request->input('status'),
            'tags' => json_decode($request->input('tagsData'), true),
        ];

        dispatch(new StorePetJob($data));

        return redirect()->route('pets.index')->with('status', 'Zwierzak został pomyślnie dodany do kolejki');
    }

    public function update(UpdatePetRequest $request, $id)
    {

        try {
            $this->client->post(config('app.pet_api_url') .'/'. $id, [
                'form_params' => [
                    'name' => $request->input('name'),
                    'status' => $request->input('status'),
                ],
            ]);

        } catch (RequestException $ex) {
            abort(404, 'Żądanie API nie powiodło się');
        }

        return redirect()->route('pets.index')->with('status', 'Zwierzak został pomyślnie zaktualizowany');
    }
}
