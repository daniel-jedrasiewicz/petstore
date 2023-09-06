<?php

namespace App\Http\Controllers;

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
    protected $apiBaseUrl;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
        $this->client = new Client();
        $this->apiBaseUrl = config('app.pet_api_url');
    }

    public function index(Request $request): View
    {
        $selectedStatus = $request->input('status', 'available');

        try {
            $response = $this->client->request('GET', $this->apiBaseUrl . '/findByStatus', [
                'query' => [
                    'status' => $selectedStatus,
                ],
            ]);

        } catch (RequestException $ex) {
            abort(404, 'API request failed');
        }

        $data = $this->parseJsonResponse($response);

        $pets = $this->petService->paginate($data, $request);

        return view('pets.index', compact('pets', 'selectedStatus'));
    }
    public function edit(int $id)
    {
        try {
            $response = $this->client->request('GET', $this->apiBaseUrl . '/' . $id);

        } catch (RequestException $ex) {
            abort(404, 'API request failed');
        }

        $pet = $this->parseJsonResponse($response);

        $selectedTags = [];

        if (isset($pet['tags']) && is_array($pet['tags'])) {
            $selectedTags = array_column($pet['tags'], 'id');
        }

        return view('pets.edit', compact('pet', 'selectedTags'));
    }
    public function create(Request $request): View
    {
        return view('pets.create', [
            'selectedTags' => $request->input('tags', []),
        ]);
    }
    public function store(StorePetRequest $request)
    {
        $tagsData = $request->input('tagsData');
        $categoriesData =$request->input('categoriesData');

        $data = [
            'name' => $request->input('name'),
            'category' => json_decode(html_entity_decode($categoriesData))[0] ?? null,
            'status' => $request->input('status'),
            'tags' =>json_decode(html_entity_decode($tagsData), true),
        ];

        dispatch(new StorePetJob($data, $this->apiBaseUrl));

        return redirect()->route('pets.index')->with('status', __('pets.messages.create'));
    }
    public function update(UpdatePetRequest $request, int $id)
    {

        try {
            $this->client->post($this->apiBaseUrl . '/' . $id, [
                'form_params' => [
                    'name' => $request->input('name'),
                    'status' => $request->input('status'),
                ],
            ]);

        } catch (RequestException $ex) {
            abort(404, 'API request failed');
        }

        return redirect()->route('pets.index')->with('status', __('pets.messages.update'));
    }
    public function delete(int $id)
    {

        try {
            $this->client->request('DELETE', $this->apiBaseUrl . '/' . $id);

        } catch (RequestException $ex) {
            abort(404, 'API request failed');
        }

        return redirect()->route('pets.index')->with('status', __('pets.messages.delete'));
    }
    private function parseJsonResponse($response)
    {
        $data = json_decode($response->getBody(), true);

        if (empty($data)) {
            abort(404, 'API returned empty data');
        }

        return $data;
    }
}
