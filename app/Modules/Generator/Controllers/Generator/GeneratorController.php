<?php

namespace App\Modules\Generator\Controllers\Generator;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Modules\Generator\Models\Generator\GeneratorImageModel;
use App\Modules\Generator\Models\Generator\GeneratorImageResourceModel;
use App\Modules\Generator\Services\FirebaseStorageService;


class GeneratorController extends Controller
{

    public function load()

    {
        return GeneratorImageResourceModel::with('images')
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getImages(Request $request)
    {
        $imageResourceId = $request->input('imageResourceId');
        $imageRecourseModel = GeneratorImageResourceModel::findOrFail($imageResourceId);

        if (!$imageRecourseModel) {
            return response()->json(['error' => 'Failed to get image resource item'], 500);
        }
        return $imageRecourseModel->images;
    }

    public function addResource(Request $request, FirebaseStorageService $imageUploadService)
    {
        $imageBase64 = $request->input('imageBase64');
        $imageOriginalUrl = $request->input('imageUrl');
        $iterationAmount = $request->input('iterationAmount');

        if (!$imageOriginalUrl) {
            $imageUrl = $imageUploadService->uploadBase64File($imageBase64);

            if (!$imageUrl) {
                return response()->json(['error' => 'Failed to upload image resource from service'], 500);
            }
        } else {
            $imageUrl = $imageOriginalUrl;
        }


        $product = new GeneratorImageResourceModel();
        $product->iteration_amount = (int)$iterationAmount;
        $product->original_link = $imageUrl;
        $product->save();

        return response()->json(['original_link' => $product->original_link]);
    }

    public function getResource()
    {
        $model = GeneratorImageResourceModel::ofInProcess(false)->first();
        if (!$model) {
            return response()->json();
        }

        $model->in_process = true;

        $model->save();

        $model->iteration_amount = $model->iteration_amount - $model->images->count();
        return $model;
    }


    public function addImage(Request $request, FirebaseStorageService $imageUploadService)

    {
        $imageBase64 = $request->input('imageBase64');
        $imageResourceId = $request->input('imageResourceId');
        $imageRecourseModel = GeneratorImageResourceModel::findOrFail($imageResourceId);


        if (!$imageRecourseModel) {
            return response()->json(['error' => 'Failed to get image resource item'], 500);
        }

        $imageUrl = $imageUploadService->uploadBase64File($imageBase64);

        if (!$imageUrl) {
            return response()->json(['error' => 'Failed to upload image from service'], 500);
        }

        $iteration = $imageRecourseModel->iteration_amount - $imageRecourseModel->images()->count();

        $model = new GeneratorImageModel();
        $model->iteration = (int)$iteration;
        $model->original_link = $imageUrl;
        $model->generator_image_resource_id = $imageRecourseModel->id;

        $model->save();

        return $model->original_link;
    }

    public function removeResource(Request $request, FirebaseStorageService $imageUploadService)
    {
        $imageResourceId = $request->input('imageResourceId');
        $imageRecourseModel = GeneratorImageResourceModel::findOrFail($imageResourceId);

        $imagesUrl = [];

        foreach ($imageRecourseModel->images as $image) {
            $imagesUrl[] = $image->original_link;
        }

        $imageUploadService->deleteFiles($imagesUrl);

        $imageRecourseModel->images()->delete();
        $imageRecourseModel->delete();
    }

    public function fixSession()
    {
        $models = GeneratorImageResourceModel::whereHas('images', function ($query) {
            $query->where('generator_image.generator_image_resource_id', '=', DB::raw('generator_image_resource.id'))
                ->where('generator_image_resource.iteration_amount', '>', 1);
        })
            ->where('iteration_amount', '>', DB::raw('(SELECT COUNT(*) FROM generator_image WHERE generator_image.generator_image_resource_id = generator_image_resource.id)'))
            ->where('in_process', true)
            ->with('images')
            ->get();

        $models->each(function ($model) {
            $model->in_process = false;
            $model->save();
        });


        return response()->json(['result' => true]);
    }

    public function downloadFile(Request $request)
    {
        $url = $request->input('url');

        $response = Http::get($url);

        if ($response->successful()) {
            $fileContent = $response->body();

            $headers = [
                'Content-Type' => $response->header('Content-Type'),
                'Content-Disposition' => 'attachment; filename="file.blob"',
            ];

            return response($fileContent, 200, $headers);
        }
        return response('Failed to download file', 500);
    }
}
