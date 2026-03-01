<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id('guest_id');

            // Lien vers le dossier parent
            $table->foreignId('registration_id')
                ->constrained('registrations', 'registration_id')
                ->onDelete('cascade');

            $table->foreignId('invited_by_id')
                ->nullable()
                ->constrained('guests', 'guest_id')
                ->onDelete('cascade');

            $table->string('full_name');
            $table->string('dietary_notes')->nullable();

            $table->boolean('is_primary')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
