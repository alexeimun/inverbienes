<?php
namespace Rhemo\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rhemo\Repositories\SocialRepository;

class ProcessImageThumbnail implements ShouldQueue {

    use InteractsWithQueue, Queueable, SerializesModels;

    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Execute the job.
     *
     * @param SocialRepository $social
     * @return void
     */
    public function handle(SocialRepository $social) {
        //if($data['picture']) {
        //    if($data['media_type'] == 2) {
        //        $links = $social->storage()->uploadVideo();
        //        $link = $links['video'] ?? null;
        //        if($links)
        //            $data['thumbnail_id'] = $social->saveMediaAndGetId($links['thumbnail'], 1, $data['thumbnail_id'] ?? null);
        //    } else $link = $social->storage()->uploadImage($data['picture']);
        //    $data['media_id'] = $social->saveMediaAndGetId($link, $data['media_type'], $data['media_id'] ?? null);
        //}
        ///** @var object $post */
        //$post = $this->user->find($social->getUserId())
        //    ->posts()->updateOrCreate(['id' => $data['id'] ?? null], $data);
        //
        //if(isset($data['tags'])) {
        //    $horse_ids = explode(',', $data['tags']);
        //    $post->horses()->sync($horse_ids);
        //}
    }
}