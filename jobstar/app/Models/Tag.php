<?php

namespace App\Models;

use App\Models\Job;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Tag extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $hidden = ['pivot'];

    protected $guarded = [];

    public $translatedAttributes = ['name'];

    public function tags()
    {
        return $this->belongsToMany(Job::class, 'job_tag');
    }

    /**
     * Show popular list in job page Scope Define
     */
    public function scopePopular($query)
    {
        return $query->where('show_popular_list', 1);
    }
}
