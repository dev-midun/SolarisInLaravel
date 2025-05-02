<?php

namespace App\Models;

class Province extends LookupModel
{
    protected $table = 'province';
    protected $defaultSelectColumn = ['id', 'name', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
