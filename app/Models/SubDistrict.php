<?php

namespace App\Models;

class SubDistrict extends LookupModel
{
    protected $table = 'sub_district';
    protected $defaultSelectColumn = ['id', 'name', 'district_id', 'city_id', 'province_id', 'country_id'];

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

    public function distirct()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
