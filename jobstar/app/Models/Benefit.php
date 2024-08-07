<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Benefit extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $hidden = ['pivot'];

    public $translatedAttributes = ['name'];

    public function job_benefit()
    {
        return $this->belongsToMany(Job::class, 'job_benefit');
    }
}
