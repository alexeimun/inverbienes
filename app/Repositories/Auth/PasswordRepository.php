<?php

namespace Rhemo\Repositories\Auth;

use Rhemo\Mail\Mailers;
use Rhemo\Models\User;
use Rhemo\Models\UserForgotPassword;
use Rhemo\Repositories\Repository;

class PasswordRepository extends Repository {

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new repository instance.
     *
     * @param UserForgotPassword $model
     * @param User $user
     */
    public function __construct(UserForgotPassword $model, User $user) {
        $this->model = $model;
        $this->user = $user;
    }

    /**
     * @param Mailers $mailers
     * @param $email
     * @return array
     */
    public function postEmail($mailers,$email) {
        $user = $this->user->where('email', $email);
        if($user->exists()) {
            $code = str_random(6);
            $user = $user->first();
            $this->model->updateOrCreate(['email' => $email], ['email' => $email, 'code' => $code]);
            $mailers->sendEmailPasswordReset($user, $code);
            return ['code' => 200, 'access_code' => $code];
        }
        return ['code' => 401, 'msg' => 'Este correo no existe en nuestra base de datos'];
    }

    public function redeemCode($data) {
        $code = $this->model->where('code', $data['code'])
            ->where('email', $data['email']);
        if($code->exists()) {
            $code->delete();
            return ['code' => 200];
        }
        return ['code' => 401, 'msg' => 'Código no existe o mal escrito'];
    }

    public function changePassword($data) {
        $user = $this->user->where('email', $data['email'])->first();
        $user->password = app('hash')->make($data['password']);
        return $user->save();
    }

}

