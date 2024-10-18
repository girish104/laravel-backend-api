<?php

use App\Models\Business\Type;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Type::insert(array(
            [
                'title' => 'Service',
                'description' => '',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Celebrity',
                'description' => '',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Product',
                'description' => '',
                'status' => 1,
                'created_at' => now(),
            ]
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
