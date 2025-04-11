<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration
{
    public static $userTable = "users";

    public static function baseTable(Blueprint $table)
    {
        $table->uuid('id');
        $table->primary('id');

        $table->foreignUuid('created_by_id')->nullable()->constrained(Migration::$userTable);
        $table->foreignUuid('updated_by_id')->nullable()->constrained(Migration::$userTable);
        $table->timestamps();
    }

    public static function baseLookup(Blueprint $table)
    {
        Migration::baseTable($table);
        $table->string('name');
        $table->smallInteger('position')->default(0);
    }

    public static function baseLookupCode(Blueprint $table)
    {
        Migration::baseLookup($table);
        $table->string('code')->nullable();
    }

    public static function baseLookupDescription(Blueprint $table)
    {
        Migration::baseLookup($table);
        $table->text('description')->nullable();
    }

    public static function baseLookupStage(Blueprint $table)
    {
        Migration::baseLookup($table);
        $table->string('color')->nullable();
        $table->boolean('is_final_stage')->default(false);
        $table->foreignUuid('group_id')->nullable()->constrained($table->getTable());
    }

    public static function baseAccessRight(Blueprint $table, string $parentTable)
    {
        Migration::baseTable($table);
        $table->foreignUuid('user_id')->nullable()->constrained(Migration::$userTable);
        $table->foreignUuid('record_id')->nullable()->constrained($parentTable);
        $table->foreignUuid('operation')->nullable()->constrained('access_right_operation');
        $table->foreignUuid('right_level')->nullable()->constrained('access_right_level');
    }

    public static function createAccessRight(string $tableName)
    {
        Schema::create($tableName. 'Rights', function (Blueprint $table) use($tableName) {
            Migration::baseAccessRight($table, $tableName);
        });
    }

    public static function dropAccessRight(string $tableName)
    {
        Schema::dropIfExists($tableName. 'Rights');
    }
}