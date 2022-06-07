<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationText extends Model
{
    use HasFactory;

    protected $guarded = [];
    public const TRANSLATION_TEXT_TYPES = [
        0 => 'Objectives and Responsibility',
        1 => 'Application Requirement'
    ];

    /**
     * Get the language that owns the TranslationText
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class,'language_id','id');
    }

    public function trasnslationType()
    {
        return TranslationText::TRANSLATION_TEXT_TYPES[$this->translation_type];
    }
}
