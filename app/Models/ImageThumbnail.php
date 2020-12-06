<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageThumbnail extends Model
{
    use HasFactory;

    protected $table = 'image_thumbnail';
    protected $fillable = ['image_id', 'image_processor_id', 'mime_type', 'sha256'];
}
