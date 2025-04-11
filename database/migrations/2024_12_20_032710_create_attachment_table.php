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
        Schema::create('attachment', function (Blueprint $table) {
            MigrationHelper::baseTable($table);
            
            $table->string('file_name')->nullable();
            $table->integer('file_size')->default(0);
            $table->string('file_extension')->nullable();
            $table->string('path')->nullable();
            $table->string('table_name')->nullable();
            $table->uuid('record_id')->nullable();
            $table->integer('image_height')->nullable();
            $table->integer('image_width')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('profile_picture_id')->nullable()->constrained('attachment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profile_picture_id']);
            $table->dropColumn('profile_picture_id');
        });
        Schema::dropIfExists('attachment');
    }
};
