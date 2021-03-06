<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
namespace App\Model\Refund;

use App\Model\Model;

/**
 * @property int $id
 * @property int $refund_id
 * @property int $order_id
 * @property int $user_id
 * @property int $action_user_id 操作用户 0:系统
 * @property int $refund_status 退款状态
 * @property string $remark
 * @property int $created_time
 * @property int $updated_time
 */
class RefundAction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'refund_action';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'refund_id', 'order_id', 'user_id', 'action_user_id', 'refund_status', 'remark', 'created_time', 'updated_time'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'refund_id' => 'integer', 'order_id' => 'integer', 'user_id' => 'integer', 'action_user_id' => 'integer', 'refund_status' => 'integer', 'created_time' => 'integer', 'updated_time' => 'integer'];
}
