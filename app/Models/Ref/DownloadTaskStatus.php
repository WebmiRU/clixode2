<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadTaskStatus extends Model
{
    use HasFactory;

//    public $timestamps = true;
    protected $table = 'ref.download_task_status';
    protected $fillable = [
        'title',
        'key',
        'sort',
    ];

}
