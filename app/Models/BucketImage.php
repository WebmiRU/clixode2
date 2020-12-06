<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BucketImage extends Model
{
    use HasFactory;

    protected $table = 'bucket_image';
    protected $fillable = ['bucket_id', 'image_id', 'name', 'uri'];

    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
