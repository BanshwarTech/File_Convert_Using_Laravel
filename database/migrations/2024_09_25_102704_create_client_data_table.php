<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_data', function (Blueprint $table) {

            $table->id(); // Auto-incrementing primary key
            $table->string('first_name'); // Client's first name
            $table->string('last_name'); // Client's last name
            $table->string('email')->unique(); // Client's email (unique)
            $table->string('phone_number')->nullable(); // Client's phone number
            $table->string('company_name')->nullable(); // Optional company name
            $table->text('address')->nullable(); // Address field
            $table->timestamps(); // Created at and updated at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_data');
    }
};
