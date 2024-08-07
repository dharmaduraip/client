<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateResume extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['file_size','resume_url'];

    public function getFileSizeAttribute()
    {
        return get_file_size($this->file);
    }
	 public function getResumeUrlAttribute()
    {
        if (!$this->file) {
            return asset('backend/image/default.png');
        }

        return asset($this->file);
    }
}
