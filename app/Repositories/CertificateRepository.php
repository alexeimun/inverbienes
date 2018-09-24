<?php

namespace Rhemo\Repositories;

use Rhemo\Models\HorseCertificate;
use Rhemo\Models\Horse;

class CertificateRepository extends Repository {

    /**
     * @var MediaRepository
     */
    private $mediaRepository;
    /**
     * @var Horse
     */
    private $horse;

    /**
     * Create a new repository instance.
     *
     * @param HorseCertificate $model
     * @param MediaRepository $mediaRepository
     * @param Horse $horse
     */

    public function __construct(HorseCertificate $model,
        MediaRepository $mediaRepository,
        Horse $horse) {
        $this->model = $model;
        $this->mediaRepository = $mediaRepository;
        $this->horse = $horse;
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

    public function saveCertifcate($horse_id, $data) {
        $this->saveCertPic($data, 'emptyFrontPic', 'certificate_front_id');
        $this->saveCertPic($data, 'emptyBackPic', 'certificate_back_id');

        $this->horse->find($horse_id)->update(['registry' => $data['registry']]);
        unset($data['registry']);
        return $this->horse->find($horse_id)->certificate()->updateOrCreate(['id' => $data['id'] ?? null], $data);
    }

    private function saveCertPic(&$data, $empty_key, $media_key) {
        if(!$data[$empty_key]) {
            $media_id = null;
            if(isset($data['id']))
                $media_id = $this->find($data['id'])->{$media_key};

            $link = $this->storage()->uploadImage($data[$media_key]);
            $media_id = $this->saveMediaAndGetId($link, $media_id);
            $data = array_merge($data, [$media_key => $media_id]);
        }
        unset($data[$empty_key]);
    }

    public function getCertificate($id) {
        return $this->model->with(['registry_back_media',
            'registry_front_media'])->where('id', $id)->first();
    }

    public function getCertificates() {
        return $this->model->with(['registry_back_media',
            'registry_front_media'])->with(['horse' => function ($q) {
            $q->with('owner');
            $q->without(['certificate', 'prizes', 'genealogy']);
        }])->get();
    }

    public function getValidatedCertificates() {
        return $this->model->with(['registry_back_media',
            'registry_front_media'])
            ->where('is_validated', 1)->get();
    }

    public function validate($id, $value) {
        return $this->update($id, ['is_validated' => $value == 'true']);
    }

    public function getGenealogy($id) {
        return $this->model->find($id)->genealogy;
    }
}
