<?php

namespace App\Models;

use Modules\Plan\Entities\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     *  Customer scope
     * @return mixed
     */
    public function scopeCompanyData($query, $company_id = null)
    {
        return $query->where('company_id', $company_id ?? auth()->user()->companyId());
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(company::class, 'company_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
