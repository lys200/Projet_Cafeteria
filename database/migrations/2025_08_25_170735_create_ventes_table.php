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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table -> string('code_vente');
            $table -> foreignId('client_id')->constrained()->onDelete('cascade');
            $table -> foreignId('plat_id')->constrained()->onDelete('cascade');
            $table ->integer('nbre_plat');
            $table -> double('montant_total', 10, 2);
            $table -> Date('date_vente')->default(now());
            $table->timestamps();

            //contrainte pour empecher d'acheter plusieurs plats
            $table -> unique(['client_id', 'date_vente']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
