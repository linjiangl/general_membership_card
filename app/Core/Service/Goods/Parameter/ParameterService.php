<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
namespace App\Core\Service\Goods\Parameter;

use App\Core\Dao\Goods\Parameter\ParameterDao;
use App\Core\Service\AbstractService;

class ParameterService extends AbstractService
{
    protected string $dao = ParameterDao::class;
}
