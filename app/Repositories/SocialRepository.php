<?php

namespace Rhemo\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Rhemo\Models\{
    Comment, Horse, Like, Post, Profile, User
};
use Rhemo\Notifications\OneSiginal\CommentPost;
use Rhemo\Notifications\OneSiginal\FollowUser;
use Rhemo\Notifications\OneSiginal\LikePost;

class SocialRepository extends Repository {

    protected $user;
    protected $horse;
    protected $profile;
    protected $mediaRepository;
    protected $like;

    const RHEMO_ACCOUNT = 1;
    const POST_DAYS_AVAILABLE = 30;

    /**
     * Create a new repository instance.
     *
     * @param MediaRepository $mediaRepository
     * @param Post $model
     * @param User $user
     * @param Profile $profile
     * @param Like $like
     * @param Horse $horse
     */

    public function __construct(
        MediaRepository $mediaRepository,
        Post $model,
        User $user,
        Profile $profile,
        Like $like,
        Horse $horse) {
        $this->model = $model;
        $this->profile = $profile;
        $this->horse = $horse;
        $this->user = $user;
        $this->mediaRepository = $mediaRepository;
        $this->like = $like;
    }

    /**
     * @param $keyword
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @throws \Exception
     */
    public function search($keyword) {
        return $this->complexPaginate($this->prepareProfiles(urldecode($keyword)));
    }

    /**
     * @param \Rhemo\Models\Profile|Horse $model
     * @param $keyword
     * @return array
     */
    private function searchCoincidences($model, $keyword) {
        return $model->where('name', 'like', "%$keyword%")->lightProfile()->toArray();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Collection
     */
    public function followers() {
        return $this->user->find($this->getUserId())->followers()->get()
            ->groupBy('profile_type')->map(function (Collection $profiles) {
                return $profiles->map(function ($profile) {
                    return $profile->profile_id;
                });
            });
    }

    /**
     * @param $keyword
     * @return array
     */
    private function prepareProfiles($keyword) {
        $horses_profile = $this->searchCoincidences($this->horse, $keyword);
        $users_profile = $this->searchCoincidences($this->profile, $keyword);
        return array_merge($users_profile, $horses_profile);
    }

    /**
     * @param $data
     * @return object
     */
    public function savePost($data) {
        //TODO: Remove this support in the future
        if(isset($data['isRecorded'])) {
            if($data['picture']) {
                if($data['media_type'] == 2) {
                    $links = $this->storage()->uploadVideo($data);
                    $link = $links['video'] ?? null;
                    if($links)
                        $data['thumbnail_id'] = $this->saveMediaAndGetId($links['thumbnail'], 1, $data['thumbnail_id'] ?? null);
                } else $link = $this->storage()->uploadImage($data['picture']);
                $data['media_id'] = $this->saveMediaAndGetId($link, $data['media_type'], $data['media_id'] ?? null);
            }
        } else {
            if($data['picture']) {
                if($data['media_type'] == 2) {
                    $link = $this->storage()->uploadVideoNew();
                    if(isset($data['thumbnail'])) {
                        $thumb = $this->storage()->uploadImage($data['thumbnail']);
                        $data['thumbnail_id'] = $this->saveMediaAndGetId($thumb, 1, $data['thumbnail_id'] ?? null);
                    }
                } else $link = $this->storage()->uploadImage($data['picture']);
                $data['media_id'] = $this->saveMediaAndGetId($link, $data['media_type'], $data['media_id'] ?? null);
            }
        }
        /** @var object $post */
        $post = $this->user->find($this->getUserId())
            ->posts()->updateOrCreate(['id' => $data['id'] ?? null], $data);

        if(isset($data['tags'])) {
            $horse_ids = explode(',', $data['tags']);
            $post->horses()->sync($horse_ids);
        }
        return $post->fresh('horses');
    }

    /**
     * @param $id
     * @param $new_version
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function postsFrom($id, $new_version) {
        $posts = $this->user->find($id)
            ->posts()
            ->latest();
        return $new_version ? $posts->paginate() : $posts->get();
    }

    /**
     * @param $new_version
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function posts($new_version) {
        $posts = $this->user->find($this->getUserId())
            ->posts()
            ->latest();
        return $new_version ? $posts->paginate() : $posts->get();
    }

    /**
     * @param $new_version
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function timeline($new_version) {
        $following = $this->followers()->toArray();
        $following_horses = $following[1] ?? [];
        $following = $following[2] ?? [];
        $following_horses = $this->getPostTaggedHorse($following_horses);

        $posts = $this->model->where('user_id', $this->getUserId())
            ->orWhere('user_id', self::RHEMO_ACCOUNT)
            ->orWhereIn('user_id', $following)
            ->orWhereIn('id', $following_horses)->latest()->distinct();

        if($new_version)
            return $posts->paginate();
        return $posts->take(20)->get();
    }

    public function getPostTaggedHorse($tagged) {
        $post_ids = [];

        $this->horse->whereIn('id', $tagged)
            ->each(function (Horse $horse) use (&$post_ids) {
                $post_ids = array_merge($post_ids, $horse->posts()->pluck('id')->toArray());
            });
        return array_unique($post_ids);
    }

    /**
     * @param $profile_id
     * @param $data
     * @return bool
     */
    public function follow($profile_id, $data) {
        if($data['profile_type'] == 2 && $data['follow'])
            $this->user->find($profile_id)->notify(new FollowUser);

        if($data['follow'])
            $this->user->find($this->getUserId())->followable()->attach($profile_id, ['profile_type' => $data['profile_type']]);
        else  $this->user->find($this->getUserId())->followable()->detach($profile_id);
        return true;
    }

    /**
     * Get the following people profiles
     *
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function following($user_id) {
        $users = $this->user->find($user_id)->followingUsers()->distinct()->get()->toArray();
        $horses = $this->user->find($user_id)->followingHorses()->with('owner')->distinct()->get()->toArray();
        return array_merge($users, $horses);
    }

    /**
     * Get the people who follow the user profile
     *
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function followme($user_id) {
        return $this->user->find($user_id)->followingMe()->distinct()->get();
    }

    /**
     * @param $url
     * @param $media_type
     * @param null $media_id
     * @return mixed
     */
    public function saveMediaAndGetId($url, $media_type, $media_id = null) {
        $data = ['id' => $media_id, 'url' => $url, 'type' => $media_type];
        return $this->mediaRepository->save($data)->id;
    }

    public function like($id, $type) {
        $type = $type == 1 ? Post::class : Comment::class;
        $this->handleLike($type, $id);
    }

    public function getPostComments($id) {
        return $this->model->find($id)->comments()->oldest()->get();
    }

    public function getPostById($id) {
        return $this->model->where('id', $id)->with('comments')->first();
    }

    /**
     * @param $user_id
     * @param $horse_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTaggedHorsePosts($user_id, $horse_id) {
        return $this->user->find($user_id)->posts()
            ->get()->filter(function (Post $post) use ($horse_id) {
                return in_array($horse_id, explode(',', $post->tags));
            });
    }

    public function comment($id, $data) {
        $post = $this->model->find($id);
        $comment = $post->find($id)
            ->comments()->create(['body' => $data['body'],
                'user_id' => $this->getUserId()]);
        $this->notifyCommentPost($comment, $post);
        return $comment;
    }

    private function handleLike($type, $id) {
        $existing_like = $this->like->withTrashed()
            ->whereLikeableType($type)
            ->whereLikeableId($id)
            ->whereUserId($this->getUserId())->first();

        if(is_null($existing_like)) {
            if($type == Post::class)
                $this->notifyLikePost($id);
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

    public function notifyLikePost($post_id) {
        $post = $this->model->find($post_id);
        $post->user->notify(new LikePost($post));
    }

    public function notifyCommentPost($comment, Post $post) {
        $post->user->notify(new CommentPost($comment));
    }

    public function getHighligths() {
        $users_profiles = $this->getHighligthProfiles($this->profile);
        $horses_profiles = $this->getHighligthProfiles($this->horse);
        return array_merge($users_profiles, $horses_profiles);
    }

    public function getHighligthProfiles(Model $model) {
        $profiles = $model->whereHas('highlight', function (Builder $q) {
            $q->whereDate('start_date', '<=', Carbon::now())
                ->whereDate('end_date', '>=', Carbon::now());
        })->get();
        $count = $profiles->count() >= 10 ? 10 : $profiles->count();
        return $profiles->random($count)->sortByDesc(function ($profile) {
            return $profile['highlight']['priority'];
        })->values()->toArray();
    }

    public function activeProfiles() {
        return $this->profile->whereHas('highlight', function (Builder $q) {
            $q->whereDate('start_date', '>', Carbon::now())
                ->orWhereDate('end_date', '<', Carbon::now());
        })->orWhereDoesntHave('highlight')
            ->withCount('posts')
            ->latest('posts_count')
            ->paginate();
    }

}