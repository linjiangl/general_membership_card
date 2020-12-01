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

class CreateUserTable extends Migration
{
    protected $table = 'user';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('username', 30)->comment('用户名');
            $table->string('nickname', 50)->comment('昵称');
            $table->string('mobile', 20)->default('')->comment('手机');
            $table->string('avatar', 255)->default('')->comment('头像');
            $table->tinyInteger('sex', false, true)->default(0)->comment('性别 1:男, 2:女, 3:保密');
            $table->string('email', 50)->default('')->comment('邮箱');
            $table->string('password', 64)->comment('密码');
            $table->string('remember_token', 64)->default('');
            $table->string('salt', 24)->default('')->comment('加密盐');
            $table->tinyInteger('status')->default(1)->comment('状态 -1:已删除, 0:已禁用, 1:已启用, 2:待审核');
            $table->tinyInteger('is_system', false, true)->default(0)->comment('是否系统用户');
            $table->integer('lasted_login_time', false, true)->default(0)->comment('最后登录时间');
            $table->integer('mobile_verified_time', false, true)->default(0)->comment('手机验证时间');
            $table->integer('email_verified_time', false, true)->default(0)->comment('邮箱验证时间');
            $table->integer('avatar_updated_time', false, true)->default(0)->comment('头像设置时间');
            $table->integer('username_updated_time', false, true)->default(0)->comment('用户名设置时间');
            $table->integer('created_at', false, true)->default(0);
            $table->integer('updated_at', false, true)->default(0);

            $table->index(['mobile'], 'mobile');
            $table->index(['email'], 'email');
            $table->unique(['username', 'status'], 'username');
            $table->index(['nickname', 'status'], 'nickname');
            $table->index(['lasted_login_time', 'status'], 'lasted_login_time');
            $table->index(['created_at', 'status'], 'created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}
