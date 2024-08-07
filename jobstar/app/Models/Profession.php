<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Profession extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    protected $guarded = [];

    // public $translatedAttributes = ['slug'];
    public $translatedAttributes = [''];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = \Str::slug($value);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'profession_id');
    }
}
