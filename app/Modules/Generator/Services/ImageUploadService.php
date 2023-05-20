<?php

namespace App\Modules\Generator\Services;

use Illuminate\Support\Facades\Http;

class ImageUploadService
{
    private $apiKey;
    private $apiHost;

    public function __construct($apiKey, $apiHost)
    {
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    public function uploadImage($base64Image)
    {
        $response = Http::asForm()->post($this->apiHost . '/1/upload', [
            'key' => $this->apiKey,
            'image' => $base64Image
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData['data']['url'];
        }

        return null;
    }
}




