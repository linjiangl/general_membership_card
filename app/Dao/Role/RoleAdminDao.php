<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://store.yii.red
 * @document https://document.store.yii.red
 * @contact  8257796@qq.com
 */
namespace App\Dao\Role;

use App\Dao\AbstractDao;
use App\Model\Role\RoleAdmin;

class RoleAdminDao extends AbstractDao
{
    protected $model = RoleAdmin::class;

    protected $noAllowActions = [];

    /**
     * 获取管理权限
     * @param int $adminId
     * @return RoleAdmin
     */
    public function getAdminRole(int $adminId): RoleAdmin
    {
        return $this->getInfoByCondition([['admin_id', '=', $adminId]]);
    }

    /**
     * 获取管理员权限ID
     * @param int $adminId
     * @return int
     */
    public function getAdminRoleId(int $adminId): int
    {
        $info = $this->getAdminRole($adminId);
        return $info->role_id;
    }

    /**
     * 修改管理员权限
     * @param int $adminId
     * @param int $newRoleId
     */
    public function changeAdminRoleId(int $adminId, int $newRoleId): void
    {
        $adminRole = $this->getAdminRole($adminId);
        if ($adminRole->role_id != $newRoleId) {
            $adminRole->role_id = $newRoleId;
            $adminRole->save();
        }
    }

    /**
     * 重置管理员权限
     * @param int $roleId
     */
    public function resetAdminRoleId(int $roleId): void
    {
        $roleDao = new RoleDao();
        $role = $roleDao->getInfoByIdentifier();
        $this->updateByCondition([['role_id', '=', $roleId]], ['role_id', $role->id]);
    }
}
