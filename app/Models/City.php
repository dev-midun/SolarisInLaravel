<?php

namespace App\Models;

class City extends LookupModel
{
    protected $table = 'city';
    protected $defaultSelectColumn = ['id', 'name', 'province_id', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
