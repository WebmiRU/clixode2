<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image';
    protected $fillable = ['sha256', 'size', 'mime_type'];

    public function thumbnails() {
        return $this->hasMany(ImageThumbnail::class, 'image_id', 'id');
    }
}
