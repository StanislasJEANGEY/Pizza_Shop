<?php

namespace pizzashop\auth\api\domain\dto;


/**
 * @method getDescription()
 * @method getImage()
 */
class UserDTO{



    private string $email;
    private string $password;
    private int $active;
    private string $activation_token;
    private string $activation_token_expiration_date;
    private string $refresh_token;
    private string $refresh_token_expiration_date;
    private string $reset_passwd_token;
    private string $reset_passwd_token_expiration_date;
    private string $username;

    /**
     * @param string $email
     * @param string $password
     * @param int $active
     * @param string $activation_token
     * @param string $activation_token_expiration_date
     * @param string $refresh_token
     * @param string $refresh_token_expiration_date
     * @param string $reset_passwd_token
     * @param string $reset_passwd_token_expiration_date
     * @param string $username
     */
    public function __construct(string $email,
                                string $password,
                                int $active,
                                string $activation_token,
                                string $activation_token_expiration_date,
                                string $refresh_token,
                                string $refresh_token_expiration_date,
                                string $reset_passwd_token,
                                string $reset_passwd_token_expiration_date,
                                string $username)
    {
        $this->email = $email;
        $this->password = $password;
        $this->active = $active;
        $this->activation_token = $activation_token;
        $this->activation_token_expiration_date = $activation_token_expiration_date;
        $this->refresh_token = $refresh_token;
        $this->refresh_token_expiration_date = $refresh_token_expiration_date;
        $this->reset_passwd_token = $reset_passwd_token;
        $this->reset_passwd_token_expiration_date = $reset_passwd_token_expiration_date;
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function getActivationToken(): string
    {
        return $this->activation_token;
    }

    public function getActivationTokenExpirationDate(): string
    {
        return $this->activation_token_expiration_date;
    }

    public function getRefreshToken(): string
    {
        return $this->refresh_token;
    }

    public function getRefreshTokenExpirationDate(): string
    {
        return $this->refresh_token_expiration_date;
    }

    public function getResetPasswdToken(): string
    {
        return $this->reset_passwd_token;
    }

    public function getResetPasswdTokenExpirationDate(): string
    {
        return $this->reset_passwd_token_expiration_date;
    }

    public function getUsername(): string
    {
        return $this->username;
    }





}