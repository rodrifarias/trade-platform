<?php

use Hyperf\Database\Schema\{Schema, Blueprint};
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->uuid('order_id')->primary();
            $table->string('market_id', 16);
            $table->uuid('account_id');
            $table->string('side', 4);
            $table->decimal('quantity');
            $table->decimal('price');
            $table->string('status', 12);
            $table->timestamp('timestamp');
            $table->create();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
