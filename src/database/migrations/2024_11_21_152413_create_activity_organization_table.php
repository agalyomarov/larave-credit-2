<?php

use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_organization', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class);
            $table->foreignIdFor(Activity::class);
            $table->timestamps();
            $table->unique(['organization_id', 'activity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_organization');
    }
};
