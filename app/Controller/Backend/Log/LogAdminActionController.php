<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
namespace App\Controller\Backend\Log;

use App\Controller\BackendController;
use App\Core\Block\Common\Log\LogAdminActionBlock;
use App\Request\Common\BatchOperationRequest;

class LogAdminActionController extends BackendController
{
    public function batchDestroyRequest(BatchOperationRequest $request): bool
    {
        $request->validated();
        return $this->batchDestroy();
    }

    protected function block(): LogAdminActionBlock
    {
        return new LogAdminActionBlock();
    }
}
