<?php

namespace App\Jobs;

use App\Http\Controllers\FileController;
use App\Models\BucketFile;
use App\Models\File;
use App\Models\HttpDownloadTask;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FileController $fileController)
    {
        $url = 'http://212.183.159.230/iconDownload-10MB.png';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
//        dd($response);

// Then, after your curl_exec call:
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
//
        dd($header);










        $fileName = hash("sha256", $this->url);
        $filePath = $fileController->hashToPath($fileName);

        set_time_limit(0);

        $tmpFile = tmpfile();

        $ch = curl_init();

        dd($ch);

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, true);

//        curl_setopt($ch, CURLOPT_NOPROGRESS, false);
//        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, [$this, 'progress']);
        curl_setopt($ch, CURLOPT_FILE, $tmpFile);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        dd(curl_exec($ch));

        if (($response = curl_exec($ch)) !== false) {
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {

                dd($response);

                $sourceFileName = null;
                $headerFilename = '/^Content-Disposition: .*?filename=(?<f>[^\s]+|\x22[^\x22]+\x22)\x3B?.*$/m';

                if (preg_match($headerFilename, $response, $matches)) {
                    $sourceFileName = trim($matches['f'], ' ";');
                    dd($sourceFileName);
                }
//                dd($sourceFileName);
                if (!$sourceFileName) {
                    $sourceFileName = basename($this->url);
                }

                DB::transaction(function () use ($sourceFileName, $hash, $fileName) {
                    HttpDownloadTask::find($this->taskId)->update([
                        'progress' => 100,
                        'ref_http_download_task_status_id' => 10,
                    ]);

                    $file = File::create([
                        'name' => $sourceFileName,
                        'sha256' => $fileName,
                        'size' => filesize($fileName),
//                        'mime_type' =>
                    ]);

                    BucketFile::create([
                        'file_id' => $file->id,
                        'bucket_id' => $this->bucket,
                        'name' => $file->slug,
                    ]);
                });
            }
        }


        curl_close($ch);
        sleep(300);


//        fclose($fp);
    }
}
