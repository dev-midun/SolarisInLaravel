<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends BaseModel
{
    protected $table = 'profile';
    protected $defaultSelectColumn = ['id', 'name', 'email', 'phone_number', 'address', 'birthdate', 'birthplace'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function salutation(): BelongsTo
    {
        return $this->belongsTo(Salutation::class, 'salutation_id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function sub_district(): BelongsTo
    {
        return $this->belongsTo(SubDistrict::class, 'sub_district_id');
    }
}