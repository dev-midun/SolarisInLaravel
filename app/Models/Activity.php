<?php

namespace App\Models;

use App\Models\Scopes\OwnerRecordScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([OwnerRecordScope::class])]
class Activity extends BaseModel
{
    protected $table = 'activities';
    public static $displayValue = 'subject';

    public function priority() : BelongsTo
    {
        return $this->belongsTo(ActivityPriority::class, 'priority_id', 'id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(ActivityCategory::class, 'category_id', 'id');
    }

    public function result() : BelongsTo
    {
        return $this->belongsTo(ActivityResult::class, 'result_id', 'id');
    }

    public function status() : BelongsTo
    {
        return $this->belongsTo(ActivityStatus::class, 'status_id', 'id');
    }

    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contact() : BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    
    public function lead() : BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function opportunity() : BelongsTo
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
    }
}