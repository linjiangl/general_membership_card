<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://www.doubi.site
 * @document https://doc.doubi.site
 * @contact  8257796@qq.com
 */
namespace App\Service\Auth;

use App\Dao\Admin\AdminDao;
use App\Exception\CacheErrorException;
use App\Exception\HttpException;
use App\Exception\InternalException;
use App\Exception\UnauthorizedException;
use App\Model\Admin;
use Carbon\Carbon;
use Phper666\JWTAuth\JWT;
use Psr\SimpleCache\InvalidArgumentException;
use Throwable;

class AdminAuthorizationService extends AbstractAuthorizationService
{
    public function __construct(Jwt $jwt)
    {
        parent::__construct($jwt->setScene('admin'));
    }

    public function authorize()
    {
        $ssoKey = config('jwt')['scene']['admin']['sso_key'];
        $data = $this->getParserData();
        $adminId = $data[$ssoKey];
        if (! $adminId) {
            throw new UnauthorizedException();
        }

        $adminDao = new AdminDao();
        $admin = $adminDao->info($adminId);
        if (! $admin) {
            throw new UnauthorizedException();
        }

        return $admin;
    }

    /**
     * 账号登录
     * @param $account
     * @param $password
     * @return array
     */
    public function login($account, $password)
    {
        $adminDao = new AdminDao();
        $admin = $adminDao->getInfoByUsername($account);
        if (! $admin) {
            throw new InternalException('该管理员账号不存在');
        }
        /** @var Admin $admin */
        $admin = $admin->makeVisible(['password', 'salt', 'mobile', 'email']);
        $passwordHash = $this->generatePasswordHash($password, $admin->salt);
        if ($passwordHash != $admin->password) {
            throw new InternalException('账号/密码错误');
        }

        try {
            $token = $this->jwt->getToken([
                'admin_id' => $admin->id,
                'username' => $admin->username,
                'name' => $admin->name,
                'avatar' => $admin->avatar,
            ]);
            $data = [
                'token' => $this->jwt->tokenPrefix . ' ' . (string) $token,
                'exp' => $this->jwt->getTTL(),
            ];

            $admin->lasted_login_at = Carbon::now()->toDateTimeString();
            $admin->save();
        } catch (InvalidArgumentException $e) {
            throw new CacheErrorException();
        }

        return $data;
    }

    /**
     * 注册
     * @param $username
     * @param $password
     * @param $confirmPassword
     * @param array $extend
     * @return array
     */
    public function register($username, $password, $confirmPassword, $extend = [])
    {
        if (mb_strlen($password) < 6) {
            throw new InternalException('密码不能少于6位');
        }
        if ($password != $confirmPassword) {
            throw new InternalException('两次输入的密码不一样');
        }

        try {
            $adminDao = new AdminDao();
            if ($adminDao->getInfoByUsername($username)) {
                throw new InternalException('账号已注册');
            }

            $salt = $this->generateSalt();
            $passwordHash = $this->generatePasswordHash($password, $salt);
            $adminDao->create([
                'username' => $username,
                'real_name' => $extend['real_name'] ?? '',
                'password' => $passwordHash,
                'salt' => $salt,
                'avatar' => $extend['avatar'] ?? '',
                'mobile' => $extend['mobile'] ?? '',
                'email' => $extend['email'] ?? '',
                'lasted_login_at' => Carbon::now()->toDateTimeString()
            ]);

            return $this->login($username, $password);
        } catch (Throwable $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }
    }
}