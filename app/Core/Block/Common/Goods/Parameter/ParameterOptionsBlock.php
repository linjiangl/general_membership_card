<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
namespace App\Core\Block\Common\Goods\Parameter;

use App\Core\Block\BaseBlock;
use App\Core\Service\Goods\Parameter\ParameterOptionsService;

class ParameterOptionsBlock extends BaseBlock
{
    protected string $service = ParameterOptionsService::class;

    protected array $query = [
        '=' => ['parameter_id']
    ];

    public function __construct()
    {
        parent::__construct();
        $this->setSortingToOrderBy();
    }

    protected function handleSoftDelete(): void
    {
    }
}
