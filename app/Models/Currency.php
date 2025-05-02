<?php

namespace App\Models;

class Currency extends LookupModel
{
    protected $table = 'currency';
    public static $displayValue = 'symbol';
    protected $defaultSelectColumn = ['id', 'name', 'code', 'symbol'];
    protected $defaultWhereColumn = ['name', 'code', 'symbol'];
}
