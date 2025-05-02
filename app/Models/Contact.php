<?php

namespace App\Models;

use App\Models\Scopes\SameOwnerRecordScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([SameOwnerRecordScope::class])]
class Contact extends BaseModel
{
    protected $table = 'contacts';
    public static $displayValue = 'name';
    protected $defaultSelectColumn = ['id', 'name', 'account_id'];

    protected function casts(): array
    {
        return array_merge(parent::casts(),
        [
            'monetary' => 'float',
            'frequency' => 'integer'
        ]);
    }

    protected static function booted(): void
    {
        parent::booted();

        static::updated(function (Contact $contact) {
            if($contact->wasChanged('account_id')) {
                $prevAccountId = $contact->getOriginal('account_id');
                if(!is_null($prevAccountId)) {
                    $account = Account::select('id', 'primary_contact_id')
                        ->where('id', $prevAccountId)
                        ->where('primary_contact_id', $contact->id)
                        ->first();
                    if(!is_null($account)) {
                        $account->primary_contact_id = null;
                        $account->save();
                    }
                }
            }
        });
    }
    
    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function gender() : BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function religion() : BelongsTo
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }

    public function preferred_language() : BelongsTo
    {
        return $this->belongsTo(PreferredLanguage::class, 'preferred_language_id', 'id');
    }

    public function estimated_income() : BelongsTo
    {
        return $this->belongsTo(EstimatedIncome::class, 'estimated_income_id', 'id');
    }

    public function marital_status() : BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id', 'id');
    }

    public function customer_journey() : BelongsTo
    {
        return $this->belongsTo(CustomerJourney::class, 'customer_journey_id', 'id');
    }
    
    public function salutation() : BelongsTo
    {
        return $this->belongsTo(Salutation::class, 'salutation_id', 'id');
    }

    public function education() : BelongsTo
    {
        return $this->belongsTo(Education::class, 'education_id', 'id');
    }

    public function socioeconomic_status() : BelongsTo
    {
        return $this->belongsTo(SocioeconomicStatus::class, 'socioeconomic_status_id', 'id');
    }
    
    public function segmentation() : BelongsTo
    {
        return $this->belongsTo(Segmentation::class, 'segmentation_id', 'id');
    }
    
    public function frequency_type() : BelongsTo
    {
        return $this->belongsTo(FrequencyType::class, 'frequency_type_id', 'id');
    }
    
    public function currency() : BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    
    public function profile_picture() : BelongsTo
    {
        return $this->belongsTo(Attachment::class, 'profile_picture_id', 'id');
    }
}