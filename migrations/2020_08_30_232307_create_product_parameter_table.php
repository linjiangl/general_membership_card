<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateProductParameterTable extends Migration
{
    protected $table = 'product_parameter';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('product_id', false, true);
            $table->string('option', 30);
            $table->string('value', 100);
            $table->timestamps();

            $table->index(['product_id'], 'product_id');
        });

        Db::statement("ALTER TABLE `{$this->table}` COMMENT '商品参数'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}