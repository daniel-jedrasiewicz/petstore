<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function MongoDB\BSON\toJSON;

class StorePetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $apiBaseUrl;

    public function __construct($data, string $apiBaseUrl)
    {
        $this->data = $data;
        $this->apiBaseUrl = $apiBaseUrl;
    }

    public function handle(): void
    {

        $client = new Client();

        try {
            $client->post($this->apiBaseUrl, [
                'json' => $this->data,
            ]);

        } catch (RequestException $ex) {
            abort(404, 'Żądanie API nie powiodło się');
        }
    }
}
