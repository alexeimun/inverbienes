<?php

namespace Rhemo\Repositories;

use Rhemo\Models\Highlighted;
use Rhemo\Models\Horse;
use Rhemo\Models\Profile;
use Rhemo\Models\User;

class HighlightedRepository extends Repository {

    protected $user;
    /**
     * @var Horse
     */
    private $horse;
    /**
     * @var Profile
     */
    private $profile;

    /**
     * Create a new repository instance.
     *
     * @param Highlighted $model
     * @param User $user
     * @param Horse $horse
     * @param Profile $profile
     */

    public function __construct(Highlighted $model,
        User $user,
        Horse $horse,
        Profile $profile) {
        $this->model = $model;
        $this->user = $user;
        $this->horse = $horse;
        $this->profile = $profile;
    }

    public function save(array $data) {
        $highlight = $this->model->updateOrCreate(['id' => $data['id'] ?? null], $data);
        if($data['profile_type'] == 1)
            $this->horse->find($data['profile_id'])->update(['highlight_id' => $highlight->id]);
        else $this->user->find($data['profile_id'])->profile()->update(['highlight_id' => $highlight->id]);

        return $highlight;
    }

    public function all($columns = ['*']) {
        $users = $this->profile->has('highlight')
            ->without(['media'])->get()->toArray();
        $horses = $this->horse->has('highlight')->with('highlight')
            ->without(['prizes', 'media', 'certificate', 'genealogy'])->get()->toArray();
        return array_merge($users, $horses);
    }

}

