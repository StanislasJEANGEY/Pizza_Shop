<?php

namespace pizzashop\auth\api\domain\entities;

use Illuminate\database\eloquent\Model;
use pizzashop\auth\api\domain\dto\UserDTO;

class User extends Model
{

    protected $connection = 'authentification';
    protected $table = 'users';
    protected $primaryKey = 'email';
    protected $keyType = 'string';

    public $timestamps = false;
    protected $fillable = ['password',
        'actve',
        'activation_token',
        'activation_token_expiration_date',
        'refresh_token',
        'refresh_token_expiration_date',
        'reset_passwd_token',
        'reset_passwd_token_expiration_date',
        'username'];
}