<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends BaseModel
{
    protected $table = 'accounts';
    public static $displayValue = 'name';

    protected function casts(): array
    {
        return array_merge(parent::casts(),
        [
            'monetary' => 'float',
            'frequency' => 'integer'
        ]);
    }

    public function type() : BelongsTo
    {
        return $this->belongsTo(AccountType::class, 'type_id', 'id');
    }
    
    public function customer_journey() : BelongsTo
    {
        return $this->belongsTo(CustomerJourney::class, 'customer_journey_id', 'id');
    }
    
    public function segmentation() : BelongsTo
    {
        return $this->belongsTo(Segmentation::class, 'segmentation_id', 'id');
    }
    
    public function frequency_type() : BelongsTo
    {
        return $this->belongsTo(FrequencyType::class, 'frequency_type_id', 'id');
    }
    
    public function business_size() : BelongsTo
    {
        return $this->belongsTo(BusinessSize::class, 'business_size_id', 'id');
    }
    
    public function ownership_type() : BelongsTo
    {
        return $this->belongsTo(OwnershipType::class, 'ownership_type_id', 'id');
    }
    
    public function number_of_employee() : BelongsTo
    {
        return $this->belongsTo(NumberOfEmployee::class, 'number_of_employee_id', 'id');
    }
    
    public function annual_revenue() : BelongsTo
    {
        return $this->belongsTo(AnnualRevenue::class, 'annual_revenue_id', 'id');
    }
    
    public function business_entity() : BelongsTo
    {
        return $this->belongsTo(BusinessEntity::class, 'business_entity_id', 'id');
    }
    
    public function industry() : BelongsTo
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }
    
    public function currency() : BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    
    public function profile_picture() : BelongsTo
    {
        return $this->belongsTo(Attachment::class, 'profile_picture_id', 'id');
    }
    
    // public function primary_contact() : BelongsTo
    // {
    //     return $this->belongsTo(Contact::class, 'primary_contact_id', 'id');
    // }
}