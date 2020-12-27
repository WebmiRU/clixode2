<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProcessorAction extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'name'];
    protected $table = 'image_processor_action';

    public function params() {
        return $this->hasMany(ImageProcessorActionParam::class, 'image_processor_action_id', 'id');
    }
//
//    public function paramValues() {
//        return $this->hasMany(\App\Models\Views\ImageProcessorActionParamValue::class, '', 'id')
//    }
}
