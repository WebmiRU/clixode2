<?php

namespace App\Http\Controllers;

use App\Models\BucketFile;
use App\Models\File;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            $filePath = $request->file('file')->getRealPath();
            $fileName = $request->file('file')->getClientOriginalName();
            $sha256 = hash_file('sha256', $filePath);
            $mimeType = mime_content_type($filePath);
            $fileSize = filesize($filePath);

            DB::beginTransaction();

            try {
                $model = File::where('sha256', $sha256)->first();

                if (!$model) {
                    $model = File::create([
                        'sha256' => $sha256,
                        'mime_type' => $mimeType,
                        'size' => $fileSize,
                    ]);
                }

                BucketFile::create([
                    'bucket_id' => $bucketId,
                    'file_id' => $model->id,
                    'name' => $fileName,
                    'uri' => $this->generateBucketFileUri(),
                ]);

                DB::commit();

                $request->file('file')->storeAs($this->hashToPath($sha256), $sha256, 'files');
            } catch (Throwable $e) {
                DB::rollBack();
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
