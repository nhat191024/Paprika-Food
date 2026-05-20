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
        Schema::create('order_item_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('extra_price', 12, 2)->default(0);
            $table->foreignId('combo_group_id')->nullable()->after('order_item_id')->constrained('combo_groups')->nullOnDelete();
            $table->foreignId('combo_group_item_id')->nullable()->after('combo_group_id')->constrained('combo_group_items')->nullOnDelete();
            $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained('product_variants')->nullOnDelete();
            $table->string('combo_group_name')->nullable()->after('product_variant_id');
            $table->string('selection_name')->nullable()->after('combo_group_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_selections');
    }
};
