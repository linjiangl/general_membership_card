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

class CreateNavigationTable extends Migration
{
    protected $table = 'navigation';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('title', 50);
            $table->string('url', 255)->default('');
            $table->tinyInteger('status')->default(0)->comment('状态 0:关闭, 1:开启');
            $table->smallInteger('sorting')->default(0)->comment('排序');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status'], 'status');
            $table->index(['sorting'], 'sorting');
        });

        Db::statement("ALTER TABLE `{$this->table}` COMMENT '导航'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}
