<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://mall.xcmei.com
 * @document https://mall.xcmei.com
 * @contact  8257796@qq.com
 */
namespace App\Core\Dao\Admin;

use App\Core\Dao\AbstractDao;
use App\Model\Admin\Admin;

class AdminDao extends AbstractDao
{
    protected string $model = Admin::class;

    protected array $noAllowActions = [];

    protected string $notFoundMessage = '管理员不存在';

    public function info(int $id, array $with = []): Admin
    {
        return parent::info($id, $with);
    }

    public function getInfoByUsername(string $username, string $symbol = '='): Admin
    {
        return $this->getInfoByCondition([['username', $symbol, $username]]);
    }

    public function getInfoByMobile(string $mobile): Admin
    {
        return $this->getInfoByCondition([['mobile', '=', $mobile]]);
    }
}
