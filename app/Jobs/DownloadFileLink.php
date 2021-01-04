<?php

namespace App\Jobs;

use App\Models\BucketFile;
use App\Models\File;
use App\Models\DownloadTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DownloadFileLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected $time;
    protected $task;
    protected $busketId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url, DownloadTask $task, int $busketId)
    {
        $this->time = time();
        $this->url = $url;
        $this->task = $task;
        $this->busketId = $busketId;
    }

    /**
     * Downloading file function
     *
     * @param $resource resource this param may be removed in new versions of CURL
     * @param $download_size
     * @param $downloaded_size
     * @param $upload_size
     * @param $uploaded_size
     */
    function progress($resource, $download_size, $downloaded_size, $upload_size, $uploaded_size)
    {
        static $previousProgress = 0;

        if ($download_size == 0) {
            $progress = 0;
        } else {
            $progress = round($downloaded_size / $download_size * 100, 2, PHP_ROUND_HALF_DOWN);

            if ((time() - $this->time) >= 1) {
                $this->time = time();

                if ($progress > $previousProgress) {
                    $previousProgress = $progress;

                    if ($this->task) {
                        $this->task->update(['progress' => $progress]);
                    }
                }
            }
        }
    }


    /**
     * Execute the job.
     *
     * @return void
     */
//    public function handle(FileController $fileController)
    public function handle()
    {
        $hash = hash("sha256", $this->url);
        $tmpFile = tmpfile();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOPROGRESS, false);
        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, [$this, 'progress']);
        curl_setopt($ch, CURLOPT_FILE, $tmpFile);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        if (($response = curl_exec($ch)) !== false) {
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {

                $sourceFileName = null;
                $headerFilename = '/^Content-Disposition: .*?filename=(?<f>[^\s]+|\x22[^\x22]+\x22)\x3B?.*$/m';

                if (preg_match($headerFilename, $response, $matches)) {
                    $sourceFileName = trim($matches['f'], ' ";');
                    dd($sourceFileName);
                }

                if (!$sourceFileName) {
                    $sourceFileName = basename($this->url);
                }

                $metaDatas = stream_get_meta_data($tmpFile);
                $fileSize = filesize($metaDatas['uri']);
                $mimeType = mime_content_type($metaDatas['uri']);

                DB::transaction(function () use ($sourceFileName, $hash, $fileSize, $mimeType) {
                    DownloadTask::find($this->task->id)->update([
                        'progress' => 100,
                        'ref_http_download_task_status_id' => 10,
                    ]);

                    $file = File::create([
                        'sha256' => $hash,
                        'size' => $fileSize,
                        'mime_type' => $mimeType
                    ]);

                    BucketFile::create([
                        'file_id' => $file->id,
                        'bucket_id' => $this->busketId,
                        'name' => $file->name,
                    ]);
                });
            }
        }

        curl_close($ch);
    }
}
