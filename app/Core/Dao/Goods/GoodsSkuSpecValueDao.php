<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
namespace App\Core\Dao\Goods;

use App\Core\Dao\AbstractDao;
use App\Model\Goods\GoodsSkuSpecValue;

class GoodsSkuSpecValueDao extends AbstractDao
{
    protected string $model = GoodsSkuSpecValue::class;

    protected array $noAllowActions = [];

    protected string $notFoundMessage = '商品关联规格值不存在';

    /**
     * 检查规格值下是否有商品
     * @param int $specValueId
     * @return bool
     */
    public function checkSpecValueIdHasGoods(int $specValueId): bool
    {
        return GoodsSkuSpecValue::query()->where('spec_value_id', $specValueId)->count() ? true : false;
    }
}
