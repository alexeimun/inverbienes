<?php

namespace Rhemo\Bridge;

use ChrisWhite\B2\Client;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class B2Storage {

    /**
     *
     * The B2 client instance
     *
     * @var Client
     */
    protected $client;

    protected const VID_MP4 = '.mp4';
    protected const VID_MOV = '.mov';

    protected $base_url = 'https://f001.backblazeb2.com/file/';

    /**
     * Create a new B2Client instance
     *
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function uploadImage($content) {
        $content = $this->base64_to_jpeg($content);
        $file = $this->client->upload([
            'BucketName' => env('B2_BUCKET'),
            'FileName' => md5(time() . uniqid()) . '.jpeg',
            'Body' => fopen($content, 'r')
        ]);

        unlink($content);
        return $this->base_url . env('B2_BUCKET') . '/' . $file->getName();
    }

    /**
     * @return null|string
     */
    public function uploadVideoNew() {
        $file = md5(time() . uniqid());
        $input_file = $file . self::VID_MP4;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $input_file)) {
            $this->convertVideo($input_file);

            $file = $this->client->upload([
                'BucketName' => env('B2_BUCKET'),
                'FileName' => $input_file,
                'Body' => fopen("tmp_$input_file", 'r')
            ]);

            unlink($input_file);
            unlink("tmp_$input_file");
            return  $this->base_url . env('B2_BUCKET') . '/' . $file->getName();
        }
        return null;
    }

    /**
     * @param $data
     * @return null|string
     */
    public function uploadVideo(&$data) {
        $file = md5(time() . uniqid());
        $input_file = $file . self::VID_MP4;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $input_file)) {
            $this->convertVideo($input_file);
            $links['thumbnail'] = $this->extractThumbnail($input_file, $data);

            $file = $this->client->upload([
                'BucketName' => env('B2_BUCKET'),
                'FileName' => $input_file,
                'Body' => fopen("tmp_$input_file", 'r')
            ]);

            unlink($input_file);
            unlink("tmp_$input_file");
            $links['video'] = $this->base_url . env('B2_BUCKET') . '/' . $file->getName();
            return $links;
        }
        return null;
    }


    private function convertVideo($file_name) {
        $process = new Process("ffmpeg -i $file_name -c:v libx264 -crf 23 -preset medium -c:a aac -b:a 128k -movflags +faststart -vf scale=-2:720,format=yuv420p -strict -2 tmp_$file_name");
        $process->run();

        if(!$process->isSuccessful())
            throw new ProcessFailedException($process);
    }

    /**
     * @param $base64_string
     * @return string
     */
    private function base64_to_jpeg($base64_string) {
        $output_file = md5(time() . uniqid()) . '.jpeg';
        $ifp = fopen($output_file, 'wb');
        $data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($data[1]));

        fclose($ifp);
        $this->optimizeImg($output_file);

        return $output_file;
    }

    private function optimizeImg($img) {
        $process = new Process("jpegoptim -m80 --strip-all --all-progressive $img");
        $process->run();

        if(!$process->isSuccessful())
            throw new ProcessFailedException($process);
    }

    private function extractThumbnail($file_name, &$data) {
        $file_img = uniqid() . '.jpg';
        $process = new Process("ffmpeg -ss 00:00:00 -i $file_name -vframes 1 -q:v 2 -strict -2 $file_img");
        $process->run();

        if(!$process->isSuccessful())
            throw new ProcessFailedException($process);

        if($data['isRecorded']) {
            $source = imagecreatefromjpeg($file_img);
            $rotate = imagerotate($source, -90, 0);
            unlink($file_img);
            $file_img = "rotated_$file_img";
            imagejpeg($rotate, $file_img);
            unset($data['isRecorded']);
        }

        $file = $this->client->upload([
            'BucketName' => env('B2_BUCKET'),
            'FileName' => 'thumb_' . $file_img,
            'Body' => fopen($file_img, 'r')
        ]);

        unlink($file_img);
        return $this->base_url . env('B2_BUCKET') . '/' . $file->getName();
    }

}
