<?php

namespace App\Http\Controllers\API;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndexResource;
use App\Jobs\DownloadFileLink;
use App\Models\BucketFile;
use App\Models\File;
use App\Models\HttpDownloadTask;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class FileController extends Controller
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

    public function post(Request $request): JsonResource
    {
        $bucketId = $request->get('bucket_id');

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->getRealPath();
            $fileName = $request->file('file')->getClientOriginalName();


            DB::beginTransaction();
            $sha256 = hash_file('sha256', $filePath);
            $mimeType = mime_content_type($filePath);
            $fileSize = filesize($filePath);

            try {
                $file = File::where('sha256', $sha256)->first();

                if (!$file) {
                    $file = File::create([
                        'sha256' => $sha256,
                        'mime_type' => $mimeType,
                        'size' => $fileSize,
                    ]);
                }

                $model = BucketFile::create([
                    'bucket_id' => $bucketId,
                    'file_id' => $file->id,
                    'name' => $fileName,
                    'uri' => $this->generateBucketFileUri(),
                ]);

                $model->load('file');

                DB::commit();

                $request->file('file')->storeAs(FileHelper::hashToPath($sha256), $sha256, 'files');

                return new IndexResource($model);
            } catch (Throwable $e) {
                DB::rollBack();

                //@TODO Return error
                dd($e->getMessage());
            }
        }
    }

    public function link(){
        $url = 'http://212.183.159.230/iconDownload-10MB.png';

        HttpDownloadTask::create([
            'url' => $url,
            'progress' => 0,
            'bucket_id' => 1,
            'ref_http_download_task_status_id' => 1,
        ]);

        DownloadFileLink::dispatch($url);
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
