<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BucketFile extends Model
{
    use HasFactory;

    protected $table = 'bucket_file';
    protected $fillable = ['bucket_id', 'file_id', 'name', 'uri'];

    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
