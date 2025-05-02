<?php

namespace App\Models;

class District extends LookupModel
{
    protected $table = 'district';
    protected $defaultSelectColumn = ['id', 'name', 'city_id', 'province_id', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
