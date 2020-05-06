<?php

declare (strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://www.doubi.site
 * @document https://doc.doubi.site
 * @contact  8257796@qq.com
 */
namespace App\Model\User;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $user_id 
 * @property int $integral 积分
 * @property float $balance 余额
 * @property int $freeze_integral 冻结的积分
 * @property float $freeze_balance 冻结的余额
 */
class UserWallet extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_wallet';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['user_id' => 'integer', 'integral' => 'integer', 'balance' => 'float', 'freeze_integral' => 'integer', 'freeze_balance' => 'float'];
}