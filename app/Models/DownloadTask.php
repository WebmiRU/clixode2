<?php

namespace App\Models;

use App\Models\Ref\DownloadTaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function status(): HasOne
    {
        return $this->hasOne(DownloadTaskStatus::class, 'id', 'file_id');
    }
}
