<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Migration as MigrationHelper;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gender', function (Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('religion', function (Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('country', function (Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('province', function (Blueprint $table) {
            MigrationHelper::baseLookupCode($table);

            $table->foreignUuid('country_id')->nullable()->constrained('country');
        });

        Schema::create('city', function (Blueprint $table) {
            MigrationHelper::baseLookup($table);

            $table->foreignUuid('province_id')->nullable()->constrained('province');
            $table->foreignUuid('country_id')->nullable()->constrained('country');
        });

        Schema::create('district', function (Blueprint $table) {
            MigrationHelper::baseLookup($table);

            $table->foreignUuid('city_id')->nullable()->constrained('city');
            $table->foreignUuid('province_id')->nullable()->constrained('province');
            $table->foreignUuid('country_id')->nullable()->constrained('country');
        });

        Schema::create('sub_district', function (Blueprint $table) {
            MigrationHelper::baseLookup($table);

            $table->string('postcode', 10)->nullable();
            $table->foreignUuid('district_id')->nullable()->constrained('district');
            $table->foreignUuid('city_id')->nullable()->constrained('city');
            $table->foreignUuid('province_id')->nullable()->constrained('province');
            $table->foreignUuid('country_id')->nullable()->constrained('country');
        });

        Schema::create('currency', function(Blueprint $table) {
            MigrationHelper::baseLookupCode($table);

            $table->string('symbol', 5)->nullable();
        });

        Schema::create('salutation', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salutation');
        Schema::dropIfExists('currency');
        Schema::dropIfExists('sub_district');
        Schema::dropIfExists('district');
        Schema::dropIfExists('city');
        Schema::dropIfExists('province');
        Schema::dropIfExists('country');
        Schema::dropIfExists('religion');
        Schema::dropIfExists('gender');
    }
};
