<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bucket extends Model
{
    use HasFactory;

    protected $table = 'bucket';

    public function files(): HasMany
    {
        return $this->hasMany(BucketFile::class, 'bucket_id', 'id');
    }
}
