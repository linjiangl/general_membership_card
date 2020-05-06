<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://www.doubi.site
 * @document https://doc.doubi.site
 * @contact  8257796@qq.com
 */

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateUserWalletLogTable extends Migration
{
    protected $table = 'user_wallet_log';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('user_id', false, true);
            $table->string('type', 30)->comment('类型 recharged:充值 consumed:消费');
            $table->decimal('amount', 9, 2)->default(0)->comment('金额');
            $table->integer('integral')->default(0)->comment('积分');
            $table->decimal('red_packet', 5, 2)->default(0)->comment('红包');
            $table->string('intro', 100)->default('')->comment('简介');
            $table->string('module', 30)->default('')->comment('模块 order:订单');
            $table->integer('module_id', false, true)->default(0);
            $table->string('remark', 255)->default('');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'type'], 'user_id_type');
            $table->index(['created_at'], 'created_at');
        });

        \Hyperf\DbConnection\Db::statement("ALTER TABLE `{$this->table}` COMMENT '用户钱包-日志'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}