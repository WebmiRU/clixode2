<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use App\Models\BucketFile;
use App\Models\BucketImage;
use App\Models\Image;
use App\Models\ImageThumbnail;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Throwable;

class ImageController extends Controller
{
    public function get(string $uri): Response
    {
        $model = BucketFile::query()
            ->with('file')
            ->where('uri', $uri)
            ->first();

        if ($model) {
            $path = $this->hashToPath($model->file->sha256);

            return response(null, 200)
                ->header('X-Accel-Redirect', "/file-storage/{$path}/{$model->file->sha256}")
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', "attachment; filename={$model->name}")
                ->header('Content-Transfer-Encoding', 'binary')
                ->header('Content-Length', $model->file->size);
        } else {
            abort(404);
        }
    }

    protected function hashToPath(string $hash): string
    {
        $segment1 = mb_substr($hash, 0, 3);
        $segment2 = mb_substr($hash, 3, 3);
        $segment3 = mb_substr($hash, 6, 3);

        return "{$segment1}/{$segment2}/{$segment3}";
    }

    public function post(Request $request): RedirectResponse
    {
        $bucketId = $request->get('bucket_id');

        if ($request->hasFile('file')) {
            $imagePath = $request->file('file')->getRealPath();
            $imageName = $request->file('file')->getClientOriginalName();

            DB::beginTransaction();

            $sha256 = hash_file('sha256', $imagePath);
            $mimeType = mime_content_type($imagePath);
            $fileSize = filesize($imagePath);

            try {
                $model = Image::where('sha256', $sha256)->first();

                if (!$model) {
                    $model = Image::create([
                        'sha256' => $sha256,
                        'mime_type' => $mimeType,
                        'size' => $fileSize,
                    ]);
                }

                BucketImage::create([
                    'bucket_id' => $bucketId,
                    'image_id' => $model->id,
                    'name' => $imageName,
                    'uri' => $this->generateBucketFileUri(),
                ]);

                $bucket = Bucket::query()
                    ->with('imageProcessors.actions')
                    ->find($bucketId);

                foreach ($bucket->imageProcessors as $imageProcessor) {
                    foreach ($imageProcessor->actions as $action) {
                        $img = ImageManagerStatic::make($imagePath);

                        switch ($action->name) {
                            case 'resize':
                                //Width param
                                $actionParamIdWidth = $action->params->where('name', 'width')->first()->id;
                                $actionParamWidthValue = $imageProcessor->actionParamValues->where('image_processor_action_param_id', $actionParamIdWidth)->first()->value;

                                //Height param
                                $actionParamIdHeight = $action->params->where('name', 'height')->first()->id;
                                $actionParamHeightValue = $imageProcessor->actionParamValues->where('image_processor_action_param_id', $actionParamIdHeight)->first()->value;

                                //Resize action
                                $img->resize($actionParamWidthValue, $actionParamHeightValue, function ($constraint) {
//                                    $constraint->aspectRatio();
                                });
                                break;
                        }



                        Storage::disk('images')->put('image101.jpg', $img->stream());
                        $pathPrefix = Storage::disk('images')->getDriver()->getAdapter()->getPathPrefix();
                        dd($pathPrefix);

                        $imageThumbnailSha256 = hash('sha256', $img->encode());

                        $imageThumbnail = ImageThumbnail::where('sha256', $imageThumbnailSha256)->first();

                        if(!$imageThumbnail) {
                            $imageThumbnail = ImageThumbnail::create([
                                'image_id' => $model->id,
                                'image_processor_id' => $imageProcessor->id,
                                'sha256' => null,
                                'mime_type' => null,
                            ]);
                        }



                    }
                }

                DB::commit();

                $request->file('file')->storeAs($this->hashToPath($sha256), $sha256, 'images');
            } catch (Throwable $e) {
                DB::rollBack();
                dd($e->getMessage());
            }
        }

        return redirect()->back();
    }

    protected function generateBucketFileUri(): string
    {
        for ($i = 0; $i < 1000; $i++) {
            $randomBytes = random_bytes(1024 * 1024);
            $sha256 = hash('sha256', $randomBytes, true);
            $uri = strtr(base64_encode($sha256), '+/=', '._-');

            $model = BucketFile::where('uri', $uri)->first();

            if (!$model) {
                return $uri;
            }
        }

        throw new Exception('Unique URI generation error');
    }
}
