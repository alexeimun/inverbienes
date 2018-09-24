<?php

namespace Rhemo\Repositories;

use Rhemo\Models\Contact;
use Rhemo\Models\User;
use Rhemo\Models\UserForgotPassword;

class UserRepository extends Repository {

    protected $userForgot;

    protected $mediaRepository;

    protected $contact;

    /**
     * Create a new repository instance.
     *
     * @param User $model
     * @param UserForgotPassword $userForgotPassword
     * @param Contact $contact
     * @param MediaRepository $mediaRepository
     */
    public function __construct(User $model,
        UserForgotPassword $userForgotPassword,
        Contact $contact,
        MediaRepository $mediaRepository) {
        $this->model = $model;
        $this->userForgot = $userForgotPassword;
        $this->mediaRepository = $mediaRepository;
        $this->contact = $contact;
    }

    public function editCurrentUser($data) {
        if(isset($data['media_id'])) {
            $link = $this->storage()->uploadImage($data['media_id']);
            $media_id = $this->saveMediaAndGetId($link);
            $data = array_merge($data, ['media_id' => $media_id]);
        }

        $profile = $this->model->find($this->getUserId())->profile();
        $profile->update($data);
        return $profile->first();
    }

    protected function saveMediaAndGetId($url) {
        $media_id = $this->model->find($this->getUserId())->profile->media_id;
        $data = ['id' => $media_id == 1 ? null : $media_id, 'url' => $url];
        return $this->mediaRepository->save($data)->id;
    }

    /**
     * Deactivates user account
     *
     * @throws \Exception
     */
    public function deactivate() {
        $user = $this->model->find($this->getUserId());
        $user->update(['active' => 0]);
        $user->profile()->update(['active' => 0]);
        $user->horses()->update(['active' => 0]);
    }

    public function all($columns = ['*']) {
        return $this->model->withTrashed()->with(['horses'])->get();
    }

    /**
     * @param $data
     * @return void
     */
    public function saveContact($data) {
        $user_id = $this->getUserId();
        $user = $this->model->find($user_id);
        $user->profile()->update(['location' => 'Medellín']);
        $data = array_except($data, ['location']);
        if(!$user->profile->contact)
            $user->profile->contact()->create($data);
        else $user->profile->contact()->update($data);
    }

}

