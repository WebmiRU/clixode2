<?php

namespace App\Http\Controllers\API;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndexResource;
use App\Models\Bucket;
use App\Models\BucketImage;
use App\Models\Image;
use App\Models\ImageThumbnail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class ImageController extends Controller
{
    public function post(Request $request): JsonResource
    {
        $bucketId = $request->get('bucket_id');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->getRealPath();
//            $imageName = $request->file('file')->getClientOriginalName();

            DB::beginTransaction();

            $sha256 = hash_file('sha256', $imagePath);
            $mimeType = mime_content_type($imagePath);
            $fileSize = filesize($imagePath);

            try {
                $ImageModel = Image::where('sha256', $sha256)->first();

                if (!$ImageModel) {
                    $ImageModel = Image::create([
                        'sha256' => $sha256,
                        'mime_type' => $mimeType,
                        'size' => $fileSize,
                    ]);
                }

                $model = BucketImage::create([
                    'bucket_id' => $bucketId,
                    'image_id' => $ImageModel->id,
                    'uri' => $this->generateBucketFileUri(),
                ]);

                $bucket = Bucket::query()
                    ->with('imageProcessors.actions')
                    ->find($bucketId);

                foreach ($bucket->imageProcessors as $imageProcessor) {
                    $img = ImageManagerStatic::make($imagePath);

                    foreach ($imageProcessor->actions as $action) {
                        switch ($action->name) {
                            case 'resize':
                                //Width param
                                $actionParamIdWidth = $action->params->where('name', 'width')->first()->id;
                                $actionParamWidthValue = $imageProcessor->actionParamValues->where('image_processor_action_param_id',
                                    $actionParamIdWidth)->first()->value;

                                //Height param
                                $actionParamIdHeight = $action->params->where('name', 'height')->first()->id;
                                $actionParamHeightValue = $imageProcessor->actionParamValues->where('image_processor_action_param_id',
                                    $actionParamIdHeight)->first()->value;

                                //Resize action
                                $img->resize($actionParamWidthValue, $actionParamHeightValue, function ($constraint) {
//                                    $constraint->aspectRatio();
                                });
                                break;
                        }


//                        Storage::disk('images')->put('image101.jpg', $img->stream());
//                        $pathPrefix = Storage::disk('images')->getDriver()->getAdapter()->getPathPrefix();
//                        dd($pathPrefix);
                    }

                    //Сохраняем картинку обработанную текущим процессором
                    $imageThumbnailSha256 = hash('sha256', $img->encode());


                    $imageThumbnail = ImageThumbnail::where('sha256', $imageThumbnailSha256)->first();

                    if (!$imageThumbnail) {
                        Storage::disk('thumbnails')->put(FileHelper::hashToPath($imageThumbnailSha256).'/'.$imageThumbnailSha256, $img->stream());

                        $imageThumbnail = ImageThumbnail::create([
                            'image_id' => $ImageModel->id,
                            'image_processor_id' => $imageProcessor->id,
                            'sha256' => $imageThumbnailSha256,
                            'mime_type' => null,
                        ]);
                    }

                    $ImageModel->thumbnails()->save($imageThumbnail);
                }

                DB::commit();

//                $request->file('image')->storeAs(FileHelper::hashToPath($sha256), $sha256, 'images');
                $model->load('image');

                return new IndexResource($model);
            } catch (Throwable $e) {
                DB::rollBack();
                dd($e->getMessage());
            }
        }
    }

    protected function generateBucketFileUri(): string
    {
        for ($i = 0; $i < 1000; $i++) {
            $randomBytes = random_bytes(1024 * 1024);
            $sha256 = hash('sha256', $randomBytes, true);
            $uri = strtr(base64_encode($sha256), '+/=', '._-');

            $model = BucketImage::where('uri', $uri)->first();

            if (!$model) {
                return $uri;
            }
        }

        throw new Exception('Unique URI generation error');
    }
}
