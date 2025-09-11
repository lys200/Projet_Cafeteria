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
        Schema::create('plats', function (Blueprint $table) {
            $table->id();
            $table->string('code_plat')->unique();
            $table->string('nom_plat');
            $table->string('image')->nullable();
            $table->enum('cuisson', ['Cru', 'Cuit', 'Grillé']);
            $table->decimal('prix', 8, 2);
            $table->enum('categorie',['Dejeuner','Diner','dessert','boisson','snack']);
            $table->integer('quantite');
            $table->boolean('disponible_jour')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plats');
    }
};
