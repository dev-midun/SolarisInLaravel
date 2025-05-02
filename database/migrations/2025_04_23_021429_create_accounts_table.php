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
        Schema::create('account_type', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('customer_journey', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('segmentation', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('frequency_type', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('business_size', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('ownership_type', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('number_of_employee', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('annual_revenue', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('business_entity', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('industry', function(Blueprint $table) {
            MigrationHelper::baseLookup($table);
        });

        Schema::create('accounts', function (Blueprint $table) {
            MigrationHelper::baseTable($table);

            $table->string('name')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('primary_phone', 50)->nullable();
            $table->string('npwp', 16)->nullable();
            $table->string('also_known_as')->nullable();
            $table->string('group_company')->nullable();
            $table->string('category')->nullable();
            $table->date('recency_date')->nullable();
            $table->unsignedInteger('frequency')->default(0);
            $table->decimal('monetary', 19, 2)->default(0);
            $table->text('notes')->nullable();

            $table->foreignUuid('profile_picture_id')->nullable()->constrained('attachment');
            $table->foreignUuid('type_id')->nullable()->constrained('account_type');
            $table->foreignUuid('customer_journey_id')->nullable()->constrained('customer_journey');
            $table->foreignUuid('segmentation_id')->nullable()->constrained('segmentation');
            $table->foreignUuid('frequency_type_id')->nullable()->constrained('frequency_type');
            $table->foreignUuid('business_size_id')->nullable()->constrained('business_size');
            $table->foreignUuid('ownership_type_id')->nullable()->constrained('ownership_type');
            $table->foreignUuid('number_of_employee_id')->nullable()->constrained('number_of_employee');
            $table->foreignUuid('annual_revenue_id')->nullable()->constrained('annual_revenue');
            $table->foreignUuid('business_entity_id')->nullable()->constrained('business_entity');
            $table->foreignUuid('industry_id')->nullable()->constrained('industry');
            $table->foreignUuid('currency_id')->nullable()->constrained('currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('account_type');
        Schema::dropIfExists('customer_journey');
        Schema::dropIfExists('segmentation');
        Schema::dropIfExists('frequency_type');
        Schema::dropIfExists('business_size');
        Schema::dropIfExists('ownership_type');
        Schema::dropIfExists('number_of_employee');
        Schema::dropIfExists('annual_revenue');
        Schema::dropIfExists('business_entity');
        Schema::dropIfExists('industry');
        Schema::dropIfExists('accounts');
    }
};
