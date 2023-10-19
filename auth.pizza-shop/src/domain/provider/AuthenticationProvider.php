<?php

namespace pizzashop\auth\api\domain\provider;

use Illuminate\Database\Eloquent\Model;
use Exception;
use pizzashop\auth\api\domain\entities\User;

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
        $passwordHash = self::hashPassword($password);

        $user = new User;
        $user->username = $username;
        $user->email = $email;
        $user->password = $passwordHash;
        $user->refresh_token = null;
        $user->save();
    }

    public static function authenticateWithCredentials($username, $password): bool
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            $inputPasswordHash = hash("sha256", $password);

            if ($inputPasswordHash === $user->password) {
                return true;
            }
        }

        return false;
    }

    public static function authenticateWithRefreshToken($refreshToken): ?array
    {
        $user = User::where('refresh_token', $refreshToken)->first();

        if ($user) {
            return [$user->username, $user->email];
        }

        return null;
    }

    public static function getUserProfile($username): ?array
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            return ['username' => $user->username, 'email' => $user->email, 'refresh_token' => $user->refresh_token];
        }

        return null;
    }

    /**
     * @throws Exception
     */
    private static function hashPassword($password): string
    {
        return hash("sha256", $password);
    }
}
