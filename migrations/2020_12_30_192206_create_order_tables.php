<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;

class CreateOrderTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('user_id', false, true);
            $table->integer('goods_id', false, true);
            $table->integer('goods_sku_id', false, true);
            $table->smallInteger('quantity', false, true)->default(1)->comment('数量');
            $table->tinyInteger('is_check', false, true)->default(1)->comment('是否选中 0:否, 1:是');
            $table->tinyInteger('is_show', false, true)->default(1)->comment('是否显示 0:否, 1:是');
            $table->integer('created_time', false, true)->default(0);
            $table->integer('updated_time', false, true)->default(0);

            $table->index(['user_id', 'goods_sku_id'], 'user_goods_sku_id');
        });

        Schema::create('order', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('shop_id', false, true);
            $table->integer('buyer_id', false, true);
            $table->string('order_sn', 64)->comment('订单号');
            $table->string('payment_method', 30)->default('')->comment('支付类型');
            $table->string('payment_no', 64)->default('')->comment('第三方支付流水号');
            $table->decimal('goods_amount', 10, 2)->unsigned()->default(0)->comment('商品总金额');
            $table->decimal('total_amount', 10, 2)->unsigned()->default(0)->comment('订单总金额');
            $table->decimal('express_amount', 6, 2)->unsigned()->default(0)->comment('运费');
            $table->decimal('discount_amount', 7, 2)->unsigned()->default(0)->comment('折扣金额');
            $table->string('consignee', 50)->comment('收件人');
            $table->string('mobile', 20)->comment('手机号');
            $table->string('province', 20)->comment('省');
            $table->string('city', 20)->comment('市');
            $table->string('district', 20)->comment('区');
            $table->string('street', 50)->default('')->comment('街道');
            $table->string('address', 150)->comment('收货地址');
            $table->string('zip_code', 20)->default('')->comment('邮政编码');
            $table->tinyInteger('is_dispatched', false, true)->default(0)->comment('是否需要发货');
            $table->tinyInteger('is_comment', false, true)->default(0)->comment('是否评论');
            $table->tinyInteger('is_additional', false, true)->default(0)->comment('是否追加评论');
            $table->tinyInteger('is_credited', false, true)->default(0)->comment('是否入账');
            $table->integer('payment_time', false, true)->default(0)->comment('支付时间');
            $table->integer('dispatched_time', false, true)->default(0)->comment('发货时间');
            $table->integer('confirmed_time', false, true)->default(0)->comment('确认时间');
            $table->integer('canceled_time', false, true)->default(0)->comment('取消时间');
            $table->integer('comment_time', false, true)->default(0)->comment('评论时间');
            $table->integer('additional_comment_time', false, true)->default(0)->comment('追加评论时间');
            $table->smallInteger('status')->comment('订单状态 -1:已删除');
            $table->string('buyer_message', 255)->default('')->comment('买家留言');
            $table->string('seller_message', 255)->default('')->comment('买家留言');
            $table->string('refund_type', 30)->default('');
            $table->integer('created_time', false, true)->default(0);
            $table->integer('updated_time', false, true)->default(0);

            $table->unique(['order_sn'], 'order_sn');
            $table->index(['payment_no'], 'payment_no');
            $table->index(['mobile', 'status'], 'mobile');
            $table->index(['shop_id', 'status'], 'shop_id_status');
            $table->index(['buyer_id', 'status'], 'buyer_id_status');
            $table->index(['total_amount', 'status'], 'total_amount_status');
            $table->index(['created_time', 'status'], 'created_time');
        });

        Schema::create('order_goods', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('order_id', false, true);
            $table->integer('goods_id', false, true);
            $table->integer('goods_sku_id', false, true);
            $table->string('goods_name', 255)->comment('商品名称');
            $table->string('goods_sku_name', 255)->comment('商品属性名称');
            $table->smallInteger('quantity', false, true)->comment('数量');
            $table->decimal('total_amount', 10, 2)->unsigned()->default(0)->comment('商品总金额');
            $table->decimal('discount_amount', 10, 2)->unsigned()->default(0)->comment('折扣金额');
            $table->integer('refund_id', false, true)->default(0);
            $table->integer('refund_goods_id', false, true)->default(0);
            $table->tinyInteger('refund_status', false, true)->default(0);
            $table->string('refund_type', 30)->default('');
            $table->string('remark', 255)->default('')->comment('备注');
            $table->integer('created_time', false, true)->default(0);
            $table->integer('updated_time', false, true)->default(0);

            $table->unique(['order_id', 'goods_sku_id'], 'order_id_goods_sku_id');
            $table->index(['goods_id'], 'goods_id');
            $table->index(['goods_name'], 'goods_name');
        });

        Schema::create('order_express', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('order_id', false, true)->default(0);
            $table->integer('refund_id', false, true)->default(0);
            $table->smallInteger('express_id', false, true);
            $table->string('express_name', 20)->comment('快递名称');
            $table->string('express_no', 64)->comment('快递单号');
            $table->decimal('amount', 6, 2)->unsigned()->default(0)->comment('快递费');
            $table->integer('text_id')->default(0);
            $table->string('remark', 255)->default('');
            $table->integer('created_time', false, true)->default(0);
            $table->integer('updated_time', false, true)->default(0);

            $table->index(['order_id'], 'order_id');
            $table->index(['refund_id'], 'refund_id');
            $table->index(['express_id'], 'express_id');
            $table->index(['express_no'], 'express_no');
        });

        Schema::create('order_invoice', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('shop_id', false, true);
            $table->integer('user_id', false, true);
            $table->integer('order_id', false, true);
            $table->string('order_sn', 64);
            $table->tinyInteger('open_type', false, true)->comment('开具类型');
            $table->tinyInteger('type', false, true)->comment('发票类型');
            $table->string('title', 150)->comment('发票抬头');
            $table->string('taxpayer_no', 30)->comment('纳税人识别号');
            $table->tinyInteger('status')->default(0)->comment('状态 -1:已删除, 0:已申请, 1:待处理, 2:已处理');
            $table->string('invoice_url', 255)->comment('发票地址');
            $table->string('refused_reason', 255)->default('')->comment('拒绝理由');
            $table->text('invoice')->comment('发票内容');
            $table->integer('created_time', false, true)->default(0);
            $table->integer('updated_time', false, true)->default(0);

            $table->index(['shop_id', 'status'], 'shop_id');
            $table->index(['user_id', 'status'], 'user_id');
            $table->index(['order_id'], 'order_id');
            $table->index(['order_sn'], 'order_sn');
        });

        Db::statement("ALTER TABLE `cart` COMMENT '购物车'");
        Db::statement("ALTER TABLE `order` COMMENT '订单'");
        Db::statement("ALTER TABLE `order_goods` COMMENT '订单商品'");
        Db::statement("ALTER TABLE `order_express` COMMENT '订单物流'");
        Db::statement("ALTER TABLE `order_invoice` COMMENT '订单发票'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_goods');
        Schema::dropIfExists('order_express');
        Schema::dropIfExists('order_invoice');
    }
}
