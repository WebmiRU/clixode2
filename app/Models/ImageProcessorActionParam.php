<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProcessorActionParam extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'description', 'type', 'image_processor_action_id'];
    protected $table = 'image_processor_action_param';
}
