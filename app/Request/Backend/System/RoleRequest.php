<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://store.yii.red
 * @document https://document.store.yii.red
 * @contact  8257796@qq.com
 */
namespace App\Request\Backend\System;

use App\Constants\State\BooleanState;
use App\Constants\State\RoleState;
use App\Request\AbstractRequest;

class RoleRequest extends AbstractRequest
{
    public function rules(): array
    {
        $identifier = RoleState::getValidatedInRule(RoleState::getIdentifier());
        $boolean = BooleanState::getValidatedInRule(BooleanState::getStatus());
        $scene = $this->getScene();
        $rules = [
            'post:store' => [
                'parent_id' => 'required|integer',
                'name' => 'required|string|max:50',
                'identifier' => "required|in:{$identifier}|unique:role",
                'is_super' => 'integer|in:' . $boolean,
            ],
            'put:update' => $rules = [
                'parent_id' => 'required|integer',
                'name' => 'required|string|max:50',
                'identifier' => "required|in:{$identifier}",
                'is_super' => 'integer|in:' . $boolean,
            ]
        ];
        return $rules[$scene] ?? [];
    }

    public function attributes(): array
    {
        return [
            'parent_id' => '父级',
            'name' => '权限名称',
            'identifier' => '权限标识',
            'is_super' => '是否超级管理员',
        ];
    }
}