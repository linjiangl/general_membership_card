<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateRefundItemTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('refund_item', function (Blueprint $table) {
			$table->integerIncrements('id');
			$table->integer('refund_id', false, true);
			$table->integer('order_id', false, true);
			$table->integer('order_item_id', false, true);
			$table->integer('product_id', false, true);
			$table->integer('product_sku_id', false, true);
			$table->decimal('amount', 10, 2)->unsigned()->default(0);

			$table->unique(['refund_id', 'order_item_id'], 'refund_id_order_item_id');
			$table->index(['product_id'], 'product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_item');
    }
}