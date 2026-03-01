<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id('registration_id');

            $table->foreignId('event_id')
                ->constrained('events', 'event_id')
                ->onDelete('cascade');

            $table->string('contact_name');
            $table->string('contact_email');

            $table->enum('status', ['CONFIRMED', 'CANCELED'])->default('CONFIRMED');

            $table->timestamps();

            $table->index(['event_id', 'contact_email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
