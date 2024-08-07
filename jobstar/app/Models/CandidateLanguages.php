<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateLanguages extends Model
{
    use HasFactory;

    protected $table = 'candidate_language';

     protected $fillable = [
        'candidate_id',
        'candidate_language_id',
        'created_at',
        'updated_at'
    ];
}
