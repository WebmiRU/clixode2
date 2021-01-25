<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bucket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'uri', 'user_id', 'type'];

    protected $table = 'bucket';

    public function files(): HasMany
    {
        return $this->hasMany(BucketFile::class, 'bucket_id', 'id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(BucketImage::class, 'bucket_id', 'id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(DownloadTask::class, 'bucket_id', 'id');
    }

    public function imageProcessors(): BelongsToMany
    {
        return $this->belongsToMany(ImageProcessor::class, 'bucket_m2m_image_processor', 'bucket_id', 'image_processor_id');
    }
}
