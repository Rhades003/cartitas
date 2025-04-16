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
        Schema::create('decks_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('deck_id');
            $table->foreign('deck_id')->references('id')->on('decks');
            $table->unsignedBigInteger('card_id');
            //$table->foreign('card_id')->references('id')->on('cards');
            $table->boolean('public');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Shema::dropIfExists('decks_cards');
    }
};
