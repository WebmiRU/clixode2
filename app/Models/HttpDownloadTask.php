<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HttpDownloadTask extends Model
{
    use HasFactory;

//    public $timestamps = true;
    protected $table = 'http_download_task';
    protected $fillable = [
        'url',
        'ref_http_download_task_status_id',
        'progress',
        'bucket_id',
    ];

}
