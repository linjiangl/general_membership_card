<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
namespace App\Core\Service\Goods;

use App\Core\Dao\Goods\GoodsSpecDao;
use App\Core\Service\AbstractService;

class GoodsSpecService extends AbstractService
{
    protected string $dao = GoodsSpecDao::class;
}
