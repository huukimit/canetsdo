<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use App\BaseModel;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Input,
    Validator,
    Config,
    Auth;
use App\Models\Users\Users;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    static function hasLogin() {
        return Auth::check();
    }

    static function info() {
        return Auth::user();
    }

    static function login($email, $password, $remember = 1) {
        return Auth::attempt(['email' => $email, 'password' => $password], $remember);
    }

    /**
     *
     * @param type $email
     * @param type $password
     * @return Login admin panel
     */
    static function DoLoginAdmin($email, $password) {
        $user = self::join('hss_permission as pms', 'hss_users.id', '=', 'pms.uid')->where('pms.rid', Config::get('services.role_admin'))
                ->where('email', trim($email))
                ->where('password', Users::UserPassword($password))
                ->where('status', 1)
                ->first();
        if ($user) {
            Auth::login($user);
            return $user;
        } else {
            return false;
        }
    }

    static function logout() {
        return Auth::logout();
    }

    static function login_as($user_id) {
        return Auth::loginUsingId($user_id);
    }
}
