<?php

use Hyperf\Database\Schema\{Schema, Blueprint};
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account', function (Blueprint $table) {
            $table->uuid('account_id')->primary();
            $table->string('name', 120);
            $table->string('email', 120);
            $table->string('document', 11);
            $table->string('password', 128);
            $table->create();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
