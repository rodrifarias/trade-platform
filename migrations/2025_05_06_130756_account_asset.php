<?php

use Hyperf\Database\Schema\{Schema, Blueprint};
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_asset', function (Blueprint $table) {
            $table->uuid('account_id');
            $table->string('asset_id', 10);
            $table->decimal('quantity');
            $table->create();
            $table->primary(['account_id', 'asset_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_asset');
    }
};
