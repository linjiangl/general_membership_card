<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://www.doubi.site
 * @document https://doc.doubi.site
 * @contact  8257796@qq.com
 */
namespace App\Controller\Frontend\User;

use App\Block\Frontend\User\UserBlock;
use App\Controller\AbstractRestController;

class UserController extends AbstractRestController
{
    protected $block = UserBlock::class;
}
