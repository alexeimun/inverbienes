<?php

namespace Rhemo\Repositories;

use Carbon\Carbon;
use Rhemo\Models\CommentOffer;
use Rhemo\Models\Like;
use Rhemo\Models\Offer;
use Rhemo\Models\User;
use Rhemo\Notifications\OneSiginal\NewOffer;

class ShopRepository extends Repository {

    private const store_video = 'https://www.youtube.com/embed/wc1pOTEclzo?rel=0&controls=0&showinfo=0';
    private $mediaRepository;
    private $like;
    private $user;

    private const RHEMO_ACCOUNT_ID = 1;

    public function __construct(Offer $model,
        Like $like,
        User $user,
        MediaRepository $mediaRepository) {
        $this->mediaRepository = $mediaRepository;
        $this->model = $model;
        $this->like = $like;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getStoreVideo() {
        return self::store_video;
    }

    /**
     * @param $category
     * @return string
     */
    public function getByCategory($category) {
        return $this->model->where('category', urldecode($category))
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())->get();
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

    public function polyfillPreOrder($data) {
        if(isset($data['country_id']))
            $data['location'] = $this->getLocation('countries', $data['country_id']) . ', ' .
                $this->getLocation('states', $data['state_id']) . ', ' .
                $this->getLocation('cities', $data['city_id']);
        return $data;
    }

    private function getLocation($name, $id) {
        return \DB::table($name)->where('id', $id)->value('name');
    }

    private function savePic(&$data) {
        if(isset($data['picture']) && $data['picture']) {
            $media_id = null;
            if(isset($data['id']))
                $media_id = $this->model->find($data['id'])->media_id;

            $link = $this->storage()->uploadImage($data['picture']);
            $media_id = $this->saveMediaAndGetId($link, $media_id);
            $data = array_merge($data, ['media_id' => $media_id]);
        }
        unset($data['picture']);
    }

    public function save(array $data) {
        $this->savePic($data);
        $offer = parent::save($data);
        $this->notifyNewOfer($offer);
        return $offer;
    }

    public function notifyNewOfer($offer) {
        $this->user->find(self::RHEMO_ACCOUNT_ID)->notify(new NewOffer($offer));
    }

    public function like($id, $type) {
        $type = $type == 1 ? Offer::class : CommentOffer::class;
        $this->handleLike($type, $id);
    }

    public function getOfferComments($id) {
        return $this->model->find($id)->comments()->oldest()->get();
    }

    public function getOffer($id) {
        return $this->model->where('id', $id)->with('comments')->first();
    }

    public function comment($id, $data) {
        return $this->model->find($id)->comments()
            ->create(['body' => $data['body'],
                'user_id' => $this->getUserId()]);
    }

    public function getActiveOffers() {
        return $this->model->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())->get();
    }

    private function handleLike($type, $id) {
        $existing_like = $this->like->withTrashed()
            ->whereLikeableType($type)
            ->whereLikeableId($id)
            ->whereUserId($this->getUserId())->first();

        if(is_null($existing_like)) {
            $this->like->create([
                'user_id' => $this->getUserId(),
                'likeable_id' => $id,
                'likeable_type' => $type,
            ]);
        } else {
            if(is_null($existing_like->deleted_at))
                $existing_like->delete();
            else $existing_like->restore();
        }
    }
}
