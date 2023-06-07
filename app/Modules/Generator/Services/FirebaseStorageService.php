<?php

namespace App\Modules\Generator\Services;

use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseStorageService
{
    protected $storage;
    protected $bucket;

    public function __construct()
    {
        $this->storage = Firebase::storage();
        $this->bucket = $this->storage->getBucket();
    }

    public function uploadBase64File(string $base64Data): string
    {
        $fileData = base64_decode($base64Data);
        $randomName = uniqid('file_', true);

        $object = $this->bucket->upload($fileData, [
            'name' => "$randomName.png",
        ]);

        return $object->signedUrl(now()->addMinutes(15));
    }

    public function deleteFiles(array $urls): array
    {
        $deletedFiles = [];

        foreach ($urls as $url) {
            $object = $this->getObjectFromUrl($url);

            if ($object) {
                $object->delete();
                $deletedFiles[] = $url;
            }
        }

        return $deletedFiles;
    }

    private function getObjectFromUrl(string $url): ?\Google\Cloud\Storage\StorageObject
    {
        $objectName = $this->getObjectNameFromUrl($url);

        if ($objectName) {
            return $this->bucket->object($objectName);
        }

        return null;
    }

    private function getObjectNameFromUrl(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if ($path) {
            $segments = explode('/', $path);

            return end($segments);
        }

        return null;
    }
}
