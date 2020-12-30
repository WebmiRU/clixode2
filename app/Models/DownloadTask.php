<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadTask extends Model
{
    use HasFactory;

//    public $timestamps = true;
    protected $table = 'download_task';
    protected $fillable = [
        'url',
        'ref_download_task_status_id',
        'progress',
        'bucket_id',
    ];

}
