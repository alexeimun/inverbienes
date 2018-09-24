<?php

namespace Rhemo\Repositories;

use Rhemo\Models\Genealogy;
use Rhemo\Models\Horse;
use Rhemo\Models\HorseCertificate;
use Rhemo\Models\HorseColor;
use Rhemo\Models\HorseGenealogy;
use Rhemo\Models\HorseRace;
use Rhemo\Models\User;

class HorseRepository extends Repository {

    /**
     * @var MediaRepository
     */
    private $mediaRepository;
    /**
     * @var HorseCertificate
     */
    private $certificate;
    /**
     * @var HorseGenealogy
     */
    private $horse_genealogy;
    private $user;
    /**
     * @var Genealogy
     */
    private $genealogy;

    /**
     * Create a new repository instance.
     *
     * @param Horse $model
     * @param User $user
     * @param MediaRepository $mediaRepository
     * @param HorseCertificate $certificate
     * @param Genealogy $genealogy
     * @param HorseGenealogy $horse_genealogy
     */

    public function __construct(Horse $model,
        User $user,
        MediaRepository $mediaRepository,
        HorseCertificate $certificate,
        Genealogy $genealogy,
        HorseGenealogy $horse_genealogy) {
        $this->model = $model;
        $this->user = $user;
        $this->mediaRepository = $mediaRepository;
        $this->certificate = $certificate;
        $this->horse_genealogy = $horse_genealogy;
        $this->genealogy = $genealogy;
    }

    /**
     * Determinates if a horse exists
     *
     * @param $field
     * @param $value
     * @return Horse
     */
    public function horseRecord($field, $value) {
        return $this->model
            ->where($field, $value)
            ->where('user_id', $this->getUserId());
    }

    public function getFieldValue($id, $field) {
        return $this->model->find($id)->$field;
    }

    /**
     * @param $url
     * @param null $media_id
     * @return integer
     */
    protected function saveMediaAndGetId($url, $media_id = null) {
        $data = ['id' => $media_id, 'url' => $url];
        return $this->mediaRepository->save($data)->id;
    }

    public function all($columns = ['*']) {
        return $this->model->where('user_id', $this->getUserId())->with('posts')->get($columns);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|Horse[]
     */
    public function globalHorses() {
        return $this->model->with('highlight')->get();
    }

    /**
     * gets public user horses
     *
     * @param $user_id
     * @return \Illuminate\Support\Collection
     */
    public function userHorses($user_id) {
        return $this->user->find($user_id)->horses->load('posts');
    }

    private function validateField($field, $data) {
        $exists = false;
        if($data['exists']) {
            $horse_field = $this->getFieldValue($data['id'], $field);
            if($horse_field != $data[$field])
                $exists = $this->horseRecord($field, $data[$field])->where('id', '!=', $data['id'])->exists();
        } else $exists = $this->horseRecord($field, $data[$field])->exists();
        return $exists;
    }

    public function save(array $data) {
        if($this->validateField('name', $data))
            return ['code' => '400', 'msg' => 'Este caballo ya existe en tu pesebrera'];

        if($data['registry'] && $this->validateField('registry', $data))
            return ['code' => '400', 'msg' => 'Este registro ya existe'];

        if(!$data['emptyPic']) {
            $link = $this->storage()->uploadImage($data['picture']);
            $media_id = $this->saveMediaAndGetId($link, null);
            $data = array_merge($data, ['media_id' => $media_id]);
        }

        /** @var Horse $horse */
        $horse = $this->model->updateOrCreate(['id' => $data['id'] ?? null],
            array_merge(array_except($data, ['id', 'exists', 'emptyPic', 'picture']),
                ['user_id' => $this->getUserId()]));

        if(!$data['emptyPic'])
            $this->postHorse($horse, !isset($data['id']));

        return $horse->load(['media', 'prizes', 'posts']);
    }

    private function postHorse(Horse $horse, $isNew) {
        $posts = $this->user->find($this->getUserId());
        $body = $isNew ? 'He agregado un nuevo caballo a mi pesebrera.' : null;
        /** @var object $post */
        $post = $posts->posts()->create(['type' => 1, 'media_id' => $horse->media_id, 'body' => $body]);
        $post->horses()->attach($horse->id);
    }

    public function saveGenealogy($horse_id, $data) {
        return $this->model->find($horse_id)->genealogy()->updateOrCreate(['id' => $data['id'] ?? null], $data);
    }

    public function getHorseGenealogy($id) {
        return $this->model->find($id)->genealogy;
    }

    public function getColorsAndRaces() {
        return ['colors' => HorseColor::all(), 'races' => HorseRace::all()];
    }

    public function searchGenealogyByName($keyword) {
        return $this->genealogy->where('name', 'like', "%" . urldecode($keyword) . "%")
            ->orWhere('registry', 'like', "%" . $keyword)->take(6)->get();
    }

    public function searchAncestor($ancestor) {
        $horse = $this->queryAncestor($ancestor);
        if(!empty($horse)) {
            $horse['father'] = $this->queryAncestor([
                'name' => $horse['father_name'],
                'registry' => $horse['father_registry']
            ]);

            $horse['mother'] = $this->queryAncestor([
                'name' => $horse['mother_name'],
                'registry' => $horse['mother_registry']
            ]);
        }
        return $horse;
    }

    private function queryAncestor($ancestor) {
        $genealogy = $this->genealogy->where('name', $ancestor['name'])
            ->orWhere('registry', $ancestor['registry'])->first();

        return is_null($genealogy) ? [] : $genealogy->toArray();
    }
}

