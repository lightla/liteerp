<?php

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
        Schema::create('business_membership', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('transaction')->nullable();
            $table->foreignId('business_id')->constrained('business')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type',['trial','starter','professional','enterprise'])->default('trial');
            $table->date('start_contract_term')->nullable();
            $table->date('end_contract_term')->nullable();
            $table->bigInteger('price')->default(0);
            $table->boolean('auto_renew')->default(false);
            $table->enum('status', ['active', 'pending', 'canceled'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_membership');
    }
};
