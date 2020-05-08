<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateLogRefundTable extends Migration
{
	protected $table = 'log_refund';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
			$table->integerIncrements('id');
			$table->integer('user_id', false, true);
			$table->integer('order_id', false, true);
			$table->integer('refund_id', false, true);
			$table->string('payment_business_no', 64)->comment('支付业务号');
			$table->string('business_no', 64)->comment('退款业务号');
			$table->string('refund_method', 20)->comment('退款方式');
			$table->string('trade_no', 64)->default('')->comment('第三方退款流水号');
			$table->decimal('amount', 10, 2)->unsigned()->default(0)->comment('金额');
			$table->tinyInteger('status')->default(0)->comment('退款状态 0:未处理, 1:已处理');
			$table->string('remark', 3000)->default('');
			$table->timestamp('refund_at')->nullable();
			$table->timestamps();

			$table->unique(['business_no'], 'business_no');
			$table->unique(['trade_no'], 'trade_no');
			$table->index(['payment_business_no'], 'payment_business_no');
			$table->index(['order_id'], 'order_id');
			$table->index(['refund_id'], 'refund_id');
        });

		\Hyperf\DbConnection\Db::statement("ALTER TABLE `{$this->table}` COMMENT '退款日志'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}