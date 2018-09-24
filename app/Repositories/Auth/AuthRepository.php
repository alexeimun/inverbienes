<?php

namespace Rhemo\Repositories\Auth;

use Rhemo\Models\Profile;
use Rhemo\Models\User;
use Rhemo\Models\UserConfirmation;
use Rhemo\Repositories\Repository;

class AuthRepository extends Repository {

    /**
     * @var Profile
     */
    private $profile;

    /**
     * Create a new repository instance.
     *
     * @param User $user
     * @param Profile $profile
     */
    public function __construct(User $user, Profile $profile) {
        $this->model = $user;
        $this->profile = $profile;
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|User
     */
    public function register($data) {
        $user = $this->model->create(array_merge($this->userInput($data), [
            'password' => app('hash')->make($data['password'])
        ]));

        $this->createProfile($user->id, array_only($data, ['name', 'birthdate']));
        return $user;
    }

    public function checkEmailVerified($data) {
        if($data['account_type'] == 0) {
            $user = $this->model->where('email', $data['email'])->first();
            if(!$user->email_checked) {
                $this->sendEmailVerification($user);
                return false;
            }
        }
        return true;
    }

    public function checkActiveAccount($data) {
        $user = $this->model->withoutGlobalScopes()
            ->where('email', $data['email'])
            ->where('active', 0)
            ->where('account_type', $data['account_type'])->first();

        if(!is_null($user) && password_verify($data['password'], $user->getAuthPassword())) {
            $user->update(['active' => 1]);
            $user->profile()->withoutGlobalScopes()->update(['active' => 1]);
            $user->horses()->withoutGlobalScopes()->update(['active' => 1]);
        }
    }

    public function saveFacebookUser($data) {
        $this->checkActiveAccount(array_merge($data, ['account_type' => 1]));

        /** @var User $user */
        $user = $this->model->updateOrCreate(['email' => $data['email']],
            array_merge($this->userInput($data), [
                'account_type' => 1,
                'password' => app('hash')->make($data['email'])
            ]))->fresh('profile');

        /** @var Profile $profile */
        $profile = $user->profile()->updateOrCreate(['id' => $user->profile->id ?? null],
            array_only($data, ['name', 'birthdate']));

        if(is_null($profile->media)) {
            $media = $profile->media()->updateOrCreate(['id' => null], ['url' => $data['picture']]);
            $profile->media_id = $media->id;
            $profile->save();
        }

        return $user;
    }

    private function createProfile($id, $data) {
        $this->profile->create((array_merge($data, ['user_id' => $id, 'media_id' => 1])));
    }

    /**
     * Checks if an email exists according to the privider
     *
     * @param $email
     * @param string $provider
     * @return bool
     */
    public function accountExists($email, $provider = 'email') {
        return $this->model
            ->withoutGlobalScopes()
            ->where('email', $email)
            ->where('account_type', $provider == 'fb' ? 1 : 0)->exists();
    }

    public function checkUserPicture($data) {
        $fb_domain = 'https://graph.facebook.com';
        $user_id = $this->model->withoutGlobalScopes()
            ->where('email', $data['email'])
            ->where('account_type', 1)->first()->id;

        $profile = $this->profile->withoutGlobalScopes()
            ->where('user_id', $user_id)->first();

        if(!is_null($profile) && substr($profile->media->url, 0, 26) === $fb_domain)
            $profile->media()->update(['url' => $data['picture']]);
    }

    /**
     * @param $token
     * @return mixed|bool
     */
    public function verifyEmail($token) {
        $token = $this->model->where('email_token', $token);
        if($token->exists()) {
            $name = $token->first()->profile->name;
            $token->update([
                'email_token' => null,
                'email_checked' => true,
            ]);
            return $name;
        }

        return null;
    }

    private function userInput($data) {
        return array_only($data, ['email', 'password', 'account_type', 'email_token']);
    }

    public function sendEmailVerification(User $user) {
        $mailers = app()->make('Rhemo\Mail\Mailers');

        $this->model->find($user->id)->update([
            'email_token' => base64_encode($user->email . time())
        ]);

        $mailers->sendEmailVerification($user);
    }
}

