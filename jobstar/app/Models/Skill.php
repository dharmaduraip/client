<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Skill extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    protected $fillable = ['name','slug','created_at','updated_at'];

    public $translatedAttributes = ['name'];
}
