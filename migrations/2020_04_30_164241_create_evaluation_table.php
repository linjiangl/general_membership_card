<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://store.yii.red
 * @document https://document.store.yii.red
 * @contact  8257796@qq.com
 */
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;

class CreateEvaluationTable extends Migration
{
    protected $table = 'evaluation';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('user_id', false, true);
            $table->integer('order_id', false, true);
            $table->integer('order_item_id', false, true);
            $table->integer('product_id', false, true);
            $table->integer('product_sku_id', false, true);
            $table->tinyInteger('score', false, true)->default(0)->comment('评分');
            $table->integer('top', false, true)->default(0)->comment('点赞');
            $table->integer('reply_num', false, true)->default(0)->comment('回复数量');
            $table->integer('additional_num', false, true)->default(0)->comment('追评数量');
            $table->integer('additional_comment_id', false, true)->default(0)->comment('追评ID');
            $table->tinyInteger('is_additional', false, true)->default(0)->comment('是否追加评价 0:否,1:是');
            $table->tinyInteger('is_image', false, true)->default(0)->comment('是否带图 0:否,1:是');
            $table->tinyInteger('is_anonymous', false, true)->default(0)->comment('是否匿名 0:否,1:是');
            $table->string('content', 255)->comment('评论内容');
            $table->string('images', 1000)->default('')->comment('评论图片');
            $table->tinyInteger('status')->default(1)->comment('状态 -1:已删除, 0:待审核, 1:已通过, 2:未通过');
            $table->integer('created_at', false, true)->default(0);
            $table->integer('updated_at', false, true)->default(0);

            $table->unique(['order_item_id', 'status'], 'order_item_id');
            $table->index(['order_id', 'status'], 'order_id');
            $table->index(['user_id', 'status'], 'user_id');
            $table->index(['product_id', 'top', 'status'], 'product_id_top');
        });

        Db::statement("ALTER TABLE `{$this->table}` COMMENT '评价'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}
