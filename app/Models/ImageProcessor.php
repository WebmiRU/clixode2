<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImageProcessor extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'name', 'user_id'];
    protected $table = 'image_processor';

    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(ImageProcessorAction::class, 'image_processor_m2m_image_processor_action', 'image_processor_id', 'image_processor_action_id');
    }

    public function actionParamValues(): HasMany {
        return $this->hasMany(ImageProcessorActionParamValue::class, 'image_processor_id', 'id');
    }
}
