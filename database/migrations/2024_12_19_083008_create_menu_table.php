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
        Schema::create('menu', function (Blueprint $table) {
            MigrationHelper::baseLookup($table);
            
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('category')->nullable()->default(false);
            $table->foreignUuid('parent_id')->nullable()->constrained('menu');
            $table->foreignUuid('category_id')->nullable()->constrained('menu');
        });

        Schema::create('role_has_menu', function(Blueprint $table) {
            MigrationHelper::baseTable($table);

            $table->foreignUuid('role_id')->nullable()->constrained('roles');
            $table->foreignUuid('menu_id')->nullable()->constrained('menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_menu');
        Schema::dropIfExists('menu');
    }
};
