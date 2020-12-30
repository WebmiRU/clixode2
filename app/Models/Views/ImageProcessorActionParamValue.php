<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProcessorActionParamValue extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'view_image_processor_action_param_values';
}
