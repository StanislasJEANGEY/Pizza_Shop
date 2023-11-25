<?php

namespace pizzashop\auth\api\domain\dto;


use pizzashop\auth\api\domain\entities\User;

/**
 * @method getDescription()
 * @method getImage()
 */
class UserDTO
{


    public string $email;
    public string $password;
    public int $active;
    public string $refresh_token;
    public string $refresh_token_expiration_date;
    public string $username;

    /**
     * @param string $email
     * @param string $password
     * @param string $refresh_token
     * @param string $refresh_token_expiration_date
     * @param string $username
     */
    public function __construct(string $email,
                                string $password,
                                string $refresh_token = null,
                                string $refresh_token_expiration_date = null,
                                string $username = null)
    {
        $this->email = $email;
        $this->password = $password;
        if (isset($refresh_token)) $this->refresh_token = $refresh_token;
        if (isset($refresh_token_expiration_date)) $this->refresh_token_expiration_date = $refresh_token_expiration_date;
        if (isset($username)) $this->username = $username;
    }

    public function toUser(): User
    {
        $user  = new User();
        $user->email = $this->email;
        $user->password = $this->password;
        if (isset($this->refresh_token)) $user->refresh_token = $this->refresh_token;
        else $user->refresh_token = null;
        if (isset($this->refresh_token_expiration_date)) $user->refresh_token_expiration_date = $this->refresh_token_expiration_date;
        else $user->refresh_token_expiration_date = null;
        if (isset($this->username)) $user->username = $this->username;
        else $user->username = null;
        return $user;
    }
}