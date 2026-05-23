// PASTE THIS INTO THE create_products_table.php FILE
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->string('category')->nullable();   // NEW
        $table->boolean('in_stock')->default(true); // NEW
        $table->string('image')->nullable();       // NEW
        $table->string('tags')->nullable();
        $table->boolean('is_digital')->default(false);
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};