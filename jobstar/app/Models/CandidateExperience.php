<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Responsibility;

class CandidateExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'company',
        'company_location',
        'department',
        'start',
        'end',
        'designation',
        'responsibilities',
        'currently_working',
    ];

    protected $appends = ['formatted_start', 'formatted_end'];


    public function getFormattedStartAttribute(){
        return formatTime($this->start, 'd M Y');
    }

    public function getFormattedEndAttribute(){
        return formatTime($this->end, 'd M Y');
    }

    public function responsible()
    {
        return $this->hasMany(Responsibility::class,'candidate_experiences_id','id');
    }

}
