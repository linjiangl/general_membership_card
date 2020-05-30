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

use App\Exception\CacheErrorException;
use Hyperf\Utils\Str;
use Phper666\JWTAuth\JWT;
use Psr\SimpleCache\InvalidArgumentException;

abstract class AbstractAuthorizationService implements InterfaceAuthorizationService
{
    /**
     * @var JWT
     */
    protected $jwt;

    public function __construct(Jwt $jwt)
    {
        $this->jwt = $jwt;
    }

    public function authorize()
    {
    }

    public function login($account, $password)
    {
    }

    public function register($username, $password, $confirmPassword, $extend = [])
    {
    }

    public function logout()
    {
        try {
            return $this->jwt->logout();
        } catch (InvalidArgumentException $e) {
            throw new CacheErrorException();
        }
    }

    public function refreshToken()
    {
        try {
            $token = $this->jwt->refreshToken();
            return [
                'token' => $this->jwt->tokenPrefix . ' ' . (string) $token,
                'exp' => $this->jwt->getTTL(),
            ];
        } catch (InvalidArgumentException $e) {
            throw new CacheErrorException();
        }
    }

    public function getParserData()
    {
        return $this->jwt->getParserData();
    }

    public function generateSalt($length = 10)
    {
        return Str::random($length);
    }

    public function generatePasswordHash($password, $salt = '')
    {
        if ($salt == '') {
            $salt = $this->generateSalt();
        }
        return sha1(substr(md5($password), 0, 16) . $salt);
    }
}