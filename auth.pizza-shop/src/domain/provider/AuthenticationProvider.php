<?php

namespace pizzashop\auth\api\domain\provider;

use Exception;
use Illuminate\Database\Eloquent\Model;

class AuthenticationProvider extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'email';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @throws Exception
     */
    public static function createUser($username, $email, $password): void
    {
        list($passwordHash, $salt) = self::hashPassword($password);

        $user = new AuthenticationProvider;
        $user->username = $username;
        $user->email = $email;
        $user->password = $passwordHash;
        $user->refresh_token = null;
        $user->save();
    }

    public static function authenticateWithCredentials($username, $password): bool
    {
        $user = AuthenticationProvider::where('username', $username)->first();

        if ($user) {
            $inputPasswordHash = hash("sha256", $password . $user->salt);

            if ($inputPasswordHash === $user->password) {
                return true;
            }
        }

        return false;
    }

    public static function authenticateWithRefreshToken($refreshToken): ?array
    {
        $user = AuthenticationProvider::where('refresh_token', $refreshToken)->first();

        if ($user) {
            return [$user->username, $user->email];
        }

        return null;
    }

    public static function getUserProfile($username): ?array
    {
        $user = AuthenticationProvider::where('username', $username)->first();

        if ($user) {
            return ['username' => $user->username, 'email' => $user->email, 'refresh_token' => $user->refresh_token];
        }

        return null;
    }

    /**
     * @throws Exception
     */
    private static function hashPassword($password): array
    {
        $salt = bin2hex(random_bytes(16));
        $passwordHash = hash("sha256", $password . $salt);
        return [$passwordHash, $salt];
    }
}