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
        Schema::create('profile', function (Blueprint $table) {
            MigrationHelper::baseTable($table);

            $table->foreignUuid('user_id')->constrained('users');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->foreignUuid('salutation_id')->nullable()->constrained('salutation');
            $table->foreignUuid('gender_id')->nullable()->constrained('gender');
            $table->foreignUuid('religion_id')->nullable()->constrained('religion');
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->foreignUuid('sub_district_id')->nullable()->constrained('sub_district');
            $table->foreignUuid('district_id')->nullable()->constrained('district');
            $table->foreignUuid('city_id')->nullable()->constrained('city');
            $table->foreignUuid('province_id')->nullable()->constrained('province');
            $table->foreignUuid('country_id')->nullable()->constrained('country');
            $table->foreignUuid('company_city_id')->nullable()->constrained('city');
            $table->foreignUuid('company_province_id')->nullable()->constrained('province');
            $table->foreignUuid('company_country_id')->nullable()->constrained('country');
            $table->text('company_address')->nullable();
            $table->string('company_postcode', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
