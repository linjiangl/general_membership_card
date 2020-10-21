<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://store.yii.red
 * @document https://document.store.yii.red
 * @contact  8257796@qq.com
 */
namespace App\Core\Block\Common\Spec;

use App\Core\Block\RestBlock;
use App\Core\Service\Spec\SpecValueService;

class SpecValueBlock extends RestBlock
{
    protected $service = SpecValueService::class;
}
